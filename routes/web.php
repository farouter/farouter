<?php

use Farouter\Http\Controllers\NodeController;
use Farouter\Http\Controllers\RootController;
use Farouter\Http\Middleware\HandleFarouterInertiaRequests;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('farouter.admin_prefix', 'admin'), 'as' => 'farouter::', 'middleware' => ['web', HandleFarouterInertiaRequests::class, HandlePrecognitiveRequests::class]], function () {
    Route::get('/', RootController::class)->name('root');

    Route::group(['prefix' => 'nodes', 'as' => 'nodes.'], function () {
        Route::group(['prefix' => '{node}'], function () {
            Route::get('/create/{nodeableType}', [NodeController::class, 'create'])->name('create');
            Route::post('/{nodeableType}', [NodeController::class, 'store'])->name('store');
            Route::get('/', [NodeController::class, 'show'])->name('show');
            Route::get('/edit', [NodeController::class, 'edit'])->name('edit');
            Route::patch('/', [NodeController::class, 'update'])->name('update');
        });
    });
});
