<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PdfController;

//Route::get('/create', [OrderController::class, 'create'])->name('order.create');
//Route::view('/', 'welcome')->name('welcome');
Route::get('/', [PdfController::class, 'index'])->name('welcome');
Route::get('/download', [PdfController::class, 'download'])->name('download');