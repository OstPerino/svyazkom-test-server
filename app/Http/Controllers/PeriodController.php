<?php

namespace App\Http\Controllers;

use App\Models\Period;

class PeriodController extends Controller
{
    public function getAll() {
        $periods = Period::all();
        return $periods;
    }
}
