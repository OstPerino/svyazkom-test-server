<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\PumpMeterRecord;
use App\Models\Resident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tariff;
use App\Models\Bill;

class BillController extends Controller
{

    public function getAll() {
        $bills = Bill::with('resident', 'period')->get();
        return $bills;
    }

    public function create(Request $request) {
        $validatedData = $request->validate([
            "resident_id" => "required:int",
        ]);

        // TODO: Validation on resident
        // TODO: Add validation on is already here bill for this resident on this month
        $resident = Resident::find($validatedData["resident_id"]);

        $now = Carbon::now();
        $begin_date = $now->startOfMonth()->format('Y-m-d H:i:s');
        $end_date = $now->endOfMonth()->format('Y-m-d H:i:s');

        $period = Period::where('begin_date', $begin_date)
            ->where('end_date', $end_date)
            ->first();

        if (!$period) {
            $new_period = new Period([
                "begin_date" => $begin_date,
                "end_date" => $end_date
            ]);

            $new_period->save();
            $period_id = $new_period->id;
        } else {
            $period_id = $period->id;
        }

        $final_period = Period::find($period_id);
        $final_end_date = $final_period["end_date"];

        // TODO: Find current tariff (most closer to current month)
        $tariff = Tariff::where('begin_date', '<=', $final_end_date)
            ->orderBy('begin_date', 'desc')
            ->first();

        // TODO: Add possibility, that user can have not full month cause
        // TODO: started in this month
        $totalArea = ResidentController::getTotalArea();
        $amount_volume = $resident->area / $totalArea;
        $billAmountRub = $tariff->amount_rub * $amount_volume;

        // TODO: Filling pump meter records
        // TODO: Проверить даты (почему то не чекается часовой пояс)
        // TODO: Добавить валидацию на памп метер рекордс
        // TODO: (если уже есть на этот период, то обновляем)

        $billData = [
            "resident_id" => $resident->id,
            "period_id" => $period_id,
            "amount_rub" => $billAmountRub
        ];

        $pumpMeterRecord = [
            "period_id" => $period_id,
            "amount_volume" => $amount_volume,
        ];

        $newBill = new Bill($billData);
        $newPumpMeterRecord = new PumpMeterRecord($pumpMeterRecord);
        $newBill->save();
        $newPumpMeterRecord->save();

        return $newBill;
    }
}
