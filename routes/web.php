<?php

use Farouter\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('farouter.admin_prefix', 'admin'), 'as' => 'farouter::', 'middleware' => ['web']], function () {
    Route::group(['prefix' => 'nodes', 'as' => 'nodes.'], function () {
        Route::group(['prefix' => '{node}'], function () {
            Route::get('/', [NodeController::class, 'show'])->name('show');
        });
    });
});
