<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tariff', function (Blueprint $table) {
            $table->id();
            $table->timestampTz('begin_date');
            $table->float('amount_rub');
        });

        DB::table('tariff')->insert([
            'begin_date' => date('Y-m-d H:i:s'),
            'amount_rub' => 50,
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff');
    }
};
