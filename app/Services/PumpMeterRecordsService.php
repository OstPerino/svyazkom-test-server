<?php

namespace App\Services;

use App\Models\PumpMeterRecord;
use App\Models\Tariff;

class PumpMeterRecordsService
{

    protected PeriodService $periodService;
    protected TariffService $tariffService;
    protected ResidentService $residentService;
    protected BillService $billService;

    public function __construct(
        PeriodService $periodService,
        TariffService $tariffService,
        ResidentService $residentService,
        BillService $billService
    )
    {
        $this->periodService = $periodService;
        $this->tariffService = $tariffService;
        $this->residentService = $residentService;
        $this->billService = $billService;
    }

    public function record($body)
    {
        $tariff = Tariff::where('begin_date', '<=', $body["end_date"])
            ->orderBy('begin_date', 'desc')
            ->first();

        $period = $this->periodService->checkOrCreate($body["begin_date"], $body["end_date"]);

        $pumpMeterRecordsBody = [
            "period_id" => $period["id"],
            "amount_volume" => $body["amount_volume"]
        ];

        $pumpMeterRecords = new PumpMeterRecord($pumpMeterRecordsBody);
        $pumpMeterRecords->save();

        $this->billService->countBills(
            $tariff["amount_rub"],
            $body["amount_volume"],
            $period["id"]
        );

        return $pumpMeterRecords;
    }

    public function createOrUpdate($body)
    {
        $exist = PumpMeterRecord::where("period_id", $body["period_id"])->first();

        if ($exist) {
            $exist->fill($body);
            return $exist;
        } else {
            $pumpMeterRecord = new PumpMeterRecord($body);
            $pumpMeterRecord->save();
            return $pumpMeterRecord;
        }
    }

}
