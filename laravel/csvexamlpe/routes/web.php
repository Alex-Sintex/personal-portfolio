<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CsvController::class, 'index'])->name('index');
Route::post('/import', [CsvController::class, 'import'])->name('import');
Route::get('/export', [CsvController::class, 'export'])->name('export');
