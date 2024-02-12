<?php

namespace App\Http\Controllers;

use App\Services\PumpMeterRecordsService;
use Illuminate\Http\Request;

class PumpMeterRecordsController extends Controller
{

    protected PumpMeterRecordsService $pumpMeterRecordsService;

    public function __construct(PumpMeterRecordsService $pumpMeterRecordsService)
    {
        $this->pumpMeterRecordsService = $pumpMeterRecordsService;
    }

    public function record(Request $request)
    {
        $validatedData = $request->validate([
            "begin_date" => "nullable|date",
            "end_date" => "nullable|date",
            "amount_volume" => "required|numeric"
        ]);

        $result = $this->pumpMeterRecordsService->record($validatedData);

        return response()->json($result);
    }
//    protected PumpMeterRecordsService $pumpMeterRecordsService;
//
//    public function __construct(PumpMeterRecordsService $pumpMeterRecordsService)
//    {
//        $this->pumpMeterRecordsService = $pumpMeterRecordsService;
//    }

//    public function record(Request $request)
//    {
//        $validatedData = $request->validate([
//            "begin_date" => "nullable|date",
//            "end_date" => "nullable|date",
//            "amount_volume" => "required|numeric"
//        ]);

//        $result = $this->pumpMeterRecordsService->record($validatedData);

//        return response()->json($result);
//        return 123;
//    }

//    public function create(Request $request) {
//        $validatedData = $request->validate([
//            "begin_date" => "nullable|date",
//            "end_date" => "nullable|date",
//            "amount_volume" => "required|numeric"
//        ]);
//
//        return response()->json($validatedData);
//    }
}
