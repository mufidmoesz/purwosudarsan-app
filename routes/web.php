<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PublicArticleController;
use App\Http\Controllers\SpouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tree');
})->name('tree');

Route::get('/family-data', [FamilyController::class, 'getFamilyData']);

Route::get('/articles', [PublicArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [PublicArticleController::class, 'show'])->name('articles.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');
        Route::resource('people', PersonController::class)->except('show');
        Route::resource('spouses', SpouseController::class)->except('show');
        Route::resource('articles', ArticleController::class)->except('show');
    });
});
