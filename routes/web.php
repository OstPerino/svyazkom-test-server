<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PeriodController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Residents routes
Route::get("/api/residents", [ResidentController::class, "getAllResidents"]);
Route::get("/api/residents/{id}", [ResidentController::class, "getResidentById"]);
Route::post("/api/residents", [ResidentController::class, "createResident"]);
Route::patch("/api/residents/{id}", [ResidentController::class, "updateResident"]);
Route::delete("/api/residents/{id}", [ResidentController::class, "deleteResident"]);

// Tariff routes
Route::post("/api/tariff", [TariffController::class, "create"]);

// Bill routes
Route::post("/api/bill", [BillController::class, "create"]);
Route::get("/api/bill", [BillController::class, "getAll"]);

// Period routes
Route::get("/api/period", [PeriodController::class, "getAll"]);
