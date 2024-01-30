<?php

namespace App\Services;

use App\Models\Resident;
use App\Models\Bill;

class ResidentService {

    // TODO: Добавить возвращение эксепшнов
    public function create($body) {
        $body['start_date'] = date('Y-m-d H:i:s');

        $resident = new Resident($body);
        $resident->save();

        return $resident;
    }

    public function getAll() {
        $residents = Resident::all();
        return $residents;
    }

    public function getById($id) {
        $resident = Resident::findOrFail($id);
        return $resident;
    }

    public function update($id, $body) {
        $resident = Resident::findOrFail($id);

        $resident->fill($body);
        $resident->save();

        return $resident;
    }

    public function delete($id) {
        $resident = Resident::findOrFail($id);
        $bill = Bill::where("resident_id", $resident->id)->first();

        if ($bill) {
            throw new ("Не удалось удалить пользователя, так как ему выставлен счет");
        }

        $resident->delete();
        return $resident;
    }

    public static function getTotalArea(): float
    {
        $residents = Resident::all();
        $totalArea = 0;

        $residents->each(function (Resident $resident) use (&$totalArea) {
            $totalArea += $resident->area;
        });

        return $totalArea;
    }
}
