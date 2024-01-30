<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\TariffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;

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

// Bill routes
Route::post("/bill", [BillController::class, "create"]);
Route::get("/bill", [BillController::class, "getAll"]);
