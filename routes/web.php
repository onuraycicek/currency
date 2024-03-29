<?php

use Illuminate\Support\Facades\Route;
use Onuraycicek\Currency\Http\Controllers\CurrencyController;

Route::group(['middleware' => ['web']], function () {
    Route::post('currency', [CurrencyController::class, 'update'])->name('currency.update');
    Route::get('/currency/select2', [CurrencyController::class, 'select2'])->name('currency.select2');
});
