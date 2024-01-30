<?php

namespace App\Http\Controllers;

use App\Services\BillService;
use Illuminate\Http\Request;

class BillController extends Controller
{

    protected BillService $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function getAll() {
        $bills = $this->billService->getAll();
        return response()->json($bills);
    }

    public function create(Request $request) {
        $validatedData = $request->validate([
            "resident_id" => "required:int",
        ]);

        $bill = $this->billService->create($validatedData);

        return response()->json($bill);
    }
}
