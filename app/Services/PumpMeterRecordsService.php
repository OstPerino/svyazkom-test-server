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
        $beginDate = $body["beginDate"] ?? null;
        $endDate = $body["endDate"] ?? null;

        $period = $this->periodService->checkOrCreate($beginDate, $endDate);

        $tariff = Tariff::where('begin_date', '<=', $period["end_date"])
            ->orderBy('begin_date', 'desc')
            ->first();

        $pumpMeterRecordsBody = [
            "period_id" => $period["id"],
            "amount_volume" => $body["amount_volume"]
        ];

        $checkRecord = PumpMeterRecord::where("period_id", $period["id"])
            ->first();

        if ($checkRecord) {
            return $checkRecord;
        } else {
            $pumpMeterRecords = new PumpMeterRecord($pumpMeterRecordsBody);
            $pumpMeterRecords->save();
            $this->billService->countBills(
                $tariff["amount_rub"],
                $body["amount_volume"],
                $period["id"]
            );
            return $pumpMeterRecords;
        }
    }

}
