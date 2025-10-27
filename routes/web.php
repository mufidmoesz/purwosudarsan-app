<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;

Route::get('/', function () {
    return view('tree');
});

Route::get('/family-data', [FamilyController::class, 'getFamilyData']);

