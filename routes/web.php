<?php

use Farouter\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'farouter'], function () {
    Route::group(['prefix' => 'nodes', 'as' => 'nodes.'], function () {
        Route::group(['prefix' => '{node}'], function () {
            Route::get('/', [NodeController::class, 'show'])->name('show');
        });
    });
});
