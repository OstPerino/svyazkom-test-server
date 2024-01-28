<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariff;

class TariffController extends Controller
{

    public function create(Request $request) {
        // TODO: Add validation
        // TODO: Add exception if already exist or begin_date is passed
        $validatedData = $request->validate([
           "begin_date" => "required",
           "amount_rub" => "required",
        ]);

        $tariff = new Tariff($validatedData);

        $tariff->save();

        return $tariff;
    }
}
