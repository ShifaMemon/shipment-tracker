<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::get('shipments/data', [ShipmentController::class, 'data'])->name('shipments.data');
Route::get('shipments/{id}', [ShipmentController::class, 'show'])->name('shipments.show');

// Custom Shipment List Page (without DataTables)
Route::get('/custom-shipments', [ShipmentController::class, 'customShipmentList'])->name('shipments.custom');
