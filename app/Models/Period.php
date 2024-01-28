<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model {

    public $timestamps = false;

    protected $fillable = ["begin_date", "end_date"];

    protected $table = "periods";
}
