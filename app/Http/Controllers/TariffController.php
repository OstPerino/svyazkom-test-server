<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Services\TariffService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TariffController extends Controller
{

    protected TariffService $tariffService;

    public function __construct(TariffService $tariffService)
    {
        $this->tariffService = $tariffService;
    }

    public function create(Request $request) {
        $validatedData = $request->validate([
           "begin_date" => "required|date",
           "amount_rub" => "required|numeric|max:5000",
        ]);

        $tariff = $this->tariffService->create($validatedData);

        return response()->json($tariff);
    }

    public function getCurrentTariff(Request $request) {
        $now = Carbon::today();

        $tariff = $this->tariffService->getCurrentTariff($now);

        return response()->json($tariff);
    }
}
