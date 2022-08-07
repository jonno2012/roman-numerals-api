<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\NumeralsController;

Route::group([
    'prefix' => 'v1'
], function() {
    Route::put('/', [NumeralsController::class, 'convert'])->where(['integer' => '[0-9]+']);
    Route::get('/recent', [NumeralsController::class, 'recentlyConverted']);
    Route::get('/top-ten', [NumeralsController::class, 'topTen']);
});
