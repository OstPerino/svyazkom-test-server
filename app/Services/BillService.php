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

    public function __construct(
        PeriodService $periodService,
        TariffService $tariffService,
        ResidentService $residentService,
    )
    {
        $this->periodService = $periodService;
        $this->tariffService = $tariffService;
        $this->residentService = $residentService;
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
}
