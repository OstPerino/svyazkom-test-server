<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PumpMeterRecordsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Residents routes
Route::get("/residents", [ResidentController::class, "getAll"]);
Route::get("/residents/{id}", [ResidentController::class, "getById"]);
Route::post("/residents", [ResidentController::class, "create"]);
Route::patch("/residents/{id}", [ResidentController::class, "update"]);
Route::delete("/residents/{id}", [ResidentController::class, "delete"]);

// Period routes
Route::get("/period", [PeriodController::class, "getAll"]);

// Tariff routes
Route::post("/tariff", [TariffController::class, "create"]);
Route::get("/tariff", [TariffController::class, "getCurrentTariff"]);

// Pump meter records
Route::post("/record", [PumpMeterRecordsController::class, "record"]);

// Bills
Route::get("/bill", [BillController::class, "getAll"]);
