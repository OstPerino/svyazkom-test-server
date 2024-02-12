<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PumpMeterRecord extends Model
{

    public $timestamps = false;

    protected $fillable = ["period_id", "amount_volume"];

    protected $table = "pump_meter_records";

    protected $casts = [
        'amount_volume' => 'double',
    ];
}
