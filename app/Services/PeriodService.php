<?php

namespace App\Services;

use App\Models\Period;
use Carbon\Carbon;

class PeriodService
{

    public function getAll()
    {
        $periods = Period::all();
        return $periods;
    }

    public function getById($id)
    {
        $period = Period::find($id);
        return $period;
    }

    public function createPeriodDates(): array
    {
        $now = Carbon::now();

        $beginDate = $now->startOfMonth()->format('Y-m-d H:i:s');
        $endDate = $now->endOfMonth()->format('Y-m-d H:i:s');

        return [
            "beginDate" => $beginDate,
            "endDate" => $endDate
        ];
    }

    public function checkOrCreate($beginDate, $endDate) {

        if ($beginDate && $endDate) {
            $period = Period::where('begin_date', $beginDate)
                ->where('end_date', $endDate)
                ->first();

        } else {

            $periodData = $this->createPeriodDates();

            $newPeriod = new Period([
                "begin_date" => $periodData["beginDate"],
                "end_date" => $periodData["endDate"]
            ]);

            $checkPeriod = Period::where("begin_date", $newPeriod["begin_date"])
                ->where("end_date", $newPeriod["end_date"])
                ->first();

            if ($checkPeriod) {
                $period = $checkPeriod;
            } else {
                $newPeriod->save();
                $period = $newPeriod;
            }
        }

        return $period;
    }
}
