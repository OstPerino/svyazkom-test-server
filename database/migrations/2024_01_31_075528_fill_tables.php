<?php

use Faker\Factory as Faker;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
//        $faker = Faker::create();
//
//        for ($i = 0; $i < 10; $i++) {
//            DB::table('residents')->insert([
//                'fio' => $faker->name,
//                'area' => $faker->randomNumber(2),
//                'start_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
//            ]);
//        }
//
//        for ($i = 0; $i < 10; $i++) {
//            $beginDate = $faker->dateTimeBetween('-1 year', 'now');
//            $endDate = $faker->dateTimeBetween($beginDate, '+1 year');
//            $periodId = DB::table('periods')->insertGetId([
//                'begin_date' => $beginDate->format('Y-m-d'),
//                'end_date' => $endDate->format('Y-m-d'),
//            ]);
//
//            $residents = DB::table('residents')->pluck('id')->toArray();
//            foreach ($residents as $residentId) {
//                DB::table('bills')->insert([
//                    'resident_id' => $residentId,
//                    'period_id' => $periodId,
//                    'amount_rub' => $faker->randomFloat(2, 100, 10000),
//                ]);
//            }
//
//            DB::table('pump_meter_records')->insert([
//                'period_id' => $periodId,
//                'amount_volume' => $faker->randomFloat(2, 10, 100),
//            ]);
//        }
    }

    public function down()
    {
        // Удаление данных из таблиц
        DB::table('bills')->truncate();
        DB::table('residents')->truncate();
        DB::table('periods')->truncate();
        DB::table('pump_meter_records')->truncate();
        DB::table('personal_access_tokens')->truncate();
    }
};
