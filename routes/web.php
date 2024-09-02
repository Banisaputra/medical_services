<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterDrugController;
use App\Http\Controllers\MasterPatientController;
use App\Http\Controllers\ServiceHistoryController;

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

Route::get('/', function () {
    return view('index');
});

// master drugs
Route::get('drug', [MasterDrugController::class, 'index'])->name('masterObat.index');
Route::get('drug/create', [MasterDrugController::class, 'create'])->name('masterObat.create');
Route::post('drug/store', [MasterDrugController::class, 'store'])->name('masterObat.store');
Route::get('drug/edit/{id}', [MasterDrugController::class, 'edit'])->name('masterObat.edit');
Route::put('drug/update/{id}', [MasterDrugController::class, 'update'])->name('masterObat.update');
Route::delete('drug/{id}', [MasterDrugController::class, 'destroy'])->name('masterObat.destroy');

// master patients
Route::get('patient', [MasterPatientController::class, 'index'])->name('masterPatient.index');
Route::get('patient/create', [MasterPatientController::class, 'create'])->name('masterPatient.create');
Route::post('patient/store', [MasterPatientController::class, 'store'])->name('masterPatient.store');
Route::get('patient/edit/{id}', [MasterPatientController::class, 'edit'])->name('masterPatient.edit');
Route::put('patient/update/{id}', [MasterPatientController::class, 'update'])->name('masterPatient.update');
Route::delete('patient/{id}', [MasterPatientController::class, 'destroy'])->name('masterPatient.destroy');

// history
Route::get('history', [ServiceHistoryController::class, 'index'])->name('history.index');

// report
Route::get('report', [ServiceHistoryController::class, 'index'])->name('report.index');