<?php

namespace App\Services;

use App\Models\PumpMeterRecord;

class PumpMeterRecordsService
{

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
