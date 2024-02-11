<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model {

    public $timestamps = false;

    protected $fillable = ["begin_date", "amount_rub"];

    protected $table = "tariff";

    protected $casts = [
        'amount_rub' => 'double',
    ];

}
