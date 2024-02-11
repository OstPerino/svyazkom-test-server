<?php

namespace App\Services;

use App\Models\Tariff;

class TariffService {

    public function create($validatedData) {
        $tariff = new Tariff($validatedData);

        $tariff->save();

        return $tariff;
    }

    public function getCurrentTariff($endDate) {
        $tariff = Tariff::where('begin_date', '<=', $endDate)
            ->orderBy('begin_date', 'desc')
            ->first();

        return $tariff;
    }
}
