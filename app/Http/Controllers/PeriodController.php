<?php

namespace App\Http\Controllers;

use App\Services\PeriodService;

class PeriodController extends Controller
{

    protected PeriodService $periodService;

    public function __construct(PeriodService $periodService)
    {
        $this->periodService = $periodService;
    }

    public function getAll() {
        $periods = $this->periodService->getAll();
        return response()->json($periods);
    }
}
