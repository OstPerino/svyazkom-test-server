<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use ResidentService;

class ResidentController extends Controller
{

    protected ResidentService $residentService;

    public function __construct(ResidentService $residentService)
    {
        $this->residentService = $residentService;
    }

    public function getAllResidents() {
        $residents = Resident::all();
        return $residents;
    }

    public function getResidentById($id) {
        $resident = Resident::findOrFail($id);
        return $resident;
    }

    public function createResident(Request $request) {
        $validatedData = $request->validate([
            'fio' => 'required|max:255',
            'area' => 'required',
        ]);

        $validatedData['start_date'] = date('Y-m-d H:i:s');

        $resident = new Resident($validatedData);
        $resident->save();
    }

    public function updateResident(Request $request, $id) {
        $resident = Resident::findOrFail($id);

        $validatedData = $request->validate([
            'fio' => 'required|max:255',
            'area' => 'required',
            'start_date' => 'nullable'
        ]);

        $resident->fill($validatedData);
        $resident->save();
    }

    public function deleteResident($id) {
        // TODO: Check if is there bill on this resident
        $resident = Resident::findOrFail($id);
        $resident->delete();
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
