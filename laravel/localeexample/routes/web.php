<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LanguageController;

Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', [WelcomeController::class, 'index'])->name('example');