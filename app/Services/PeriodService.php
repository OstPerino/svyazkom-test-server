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
        $period = Period::where('begin_date', $beginDate)
            ->where('end_date', $endDate)
            ->first();

        if (!$period) {
            $newPeriod = new Period([
                "begin_date" => $beginDate,
                "end_date" => $endDate
            ]);

            $newPeriod->save();
            $periodId = $newPeriod->id;
        } else {
            $periodId = $period->id;
        }

        return $periodId;
    }
}
