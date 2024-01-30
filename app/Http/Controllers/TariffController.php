<?php

namespace App\Http\Controllers;

use App\Services\TariffService;
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
           "amount_rub" => "required|numeric",
        ]);

        $tariff = $this->tariffService->create($validatedData);

        return response()->json($tariff);
    }
}
