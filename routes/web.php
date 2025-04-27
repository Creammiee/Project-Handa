<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HandaController;

Route::get('/handa', function () {
    return view('ProjectHanda');
})->name('handa.view');

Route::post('/handa/predict', [HandaController::class, 'predict'])->name('handa.predict');
