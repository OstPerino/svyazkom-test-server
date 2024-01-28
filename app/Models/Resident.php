<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resident extends Model {

    public $timestamps = false;

    protected $fillable = ["fio", "area", "start_date"];

    protected $table = "residents";
}
