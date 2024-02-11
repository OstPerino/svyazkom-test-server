<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Resident;

use App\Models\Tariff;

class BillService
{

    protected PeriodService $periodService;
    protected TariffService $tariffService;
    protected ResidentService $residentService;
    protected PumpMeterRecordsService $pumpMeterRecordsService;

    public function __construct(
        PeriodService $periodService,
        TariffService $tariffService,
        ResidentService $residentService,
        PumpMeterRecordsService $pumpMeterRecordsService
    )
    {
        $this->periodService = $periodService;
        $this->tariffService = $tariffService;
        $this->residentService = $residentService;
        $this->pumpMeterRecordsService = $pumpMeterRecordsService;
    }

    public function getAll()
    {
        $bills = Bill::with('resident', 'period')->get();
        return $bills;
    }

    /*
     *
     * Посчитать общую стоимость (тарифф на общее кол-во воды)
     * Процент участка челика = текущая площадь * 100 / общую
     * Стоимость для участка = общая стоимость * процент участка / 100
     *
     */

    public function countBills($tariff, $amountVolume, $periodId) {
        $residents = Resident::all();

        $totalArea = $this->residentService->getTotalArea();
        $totalCost = $tariff * $amountVolume;

        foreach ($residents as $resident) {
            $area = $resident->area;

            $amountRub = $totalCost * ($area / $totalArea);
            $billData = [
                "resident_id" => $resident["id"],
                "period_id" => $periodId,
                "amount_rub" => $amountRub
            ];

            $bill = new Bill($billData);
            $bill->save();
        }
    }

    public function create($body)
    {
        $resident = Resident::find($body["resident_id"]);

        $periodDates = $this->periodService->createPeriodDates();
        $periodId = $this->periodService->checkOrCreate($periodDates["beginDate"], $periodDates["endDate"]);

        $bill = Bill::where('resident_id', $resident->id)
            ->where('period_id', $periodId)
            ->first();

        if ($bill) {
            throw new ("Для этого дачника уже выставлен счет за прошедший месяц");
        }


        $period = $this->periodService->getById($periodId);
        $tariff = $this->tariffService->getCurrentTariff($period["end_date"]);

        $amounts = $this->calculateBillAmount($resident, $tariff);
        $amountRub = $amounts["amountRub"];
        $amountVolume = $amounts["amountVolume"];

        $billData = [
            "resident_id" => $resident->id,
            "period_id" => $periodId,
            "amount_rub" => $amountRub
        ];

        $pumpMeterRecordData = [
            "period_id" => $periodId,
            "amount_volume" => $amountVolume,
        ];

        $newBill = new Bill($billData);
        $newBill->save();

        $this->pumpMeterRecordsService->createOrUpdate($pumpMeterRecordData);

        return $newBill;
    }

    public function calculateBillAmount(Resident $resident, Tariff $tariff): array
    {
        $totalArea = $this->residentService->getTotalArea();

        $amountVolume = $resident->area / $totalArea;
        $amountRub = $tariff->amount_rub * $amountVolume;

        return [
            "amountRub" => $amountRub,
            "amountVolume" => $amountVolume
        ];
    }
}
