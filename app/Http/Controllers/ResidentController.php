<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResidentService;

class ResidentController extends Controller
{

    protected ResidentService $residentService;

    public function __construct(ResidentService $residentService)
    {
        $this->residentService = $residentService;
    }

    public function getAll() {
        return $this->residentService->getAll();
    }

    public function getById($id) {
        return $this->residentService->getById($id);
    }

    public function create(Request $request) {
        $validatedData = $request->validate([
            'fio' => 'required|max:255',
            'area' => 'required|numeric',
        ]);

        $resident = $this->residentService->create($validatedData);

        return response()->json($resident);
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'fio' => 'nullable|max:255',
            'area' => 'nullable|numeric:5000',
            'start_date' => 'nullable|date'
        ]);

        $resident = $this->residentService->update($id, $validatedData);

        return response()->json($resident);
    }

    public function delete($id) {
        $resident = $this->residentService->delete($id);
        return response()->json($resident);
    }

}
