<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesseurController;

Route::get('/', function () {
    return view('welcome');
});

// Grouper toutes les routes des professeurs
Route::group(['prefix' => 'professeurs'], function () {
    Route::get('/', [ProfesseurController::class, 'index'])->name('professeur.index');
    Route::get('/create', [ProfesseurController::class, 'create'])->name('professeur.create');
    Route::post('/store', [ProfesseurController::class, 'store'])->name('professeur.store');
    Route::get('/{id}/professeur', [ProfesseurController::class, 'show'])->name('professeur.show');
    Route::get('/{id}/edit', [ProfesseurController::class, 'edit'])->name('professeur.edit');
    Route::put('/{id}', [ProfesseurController::class, 'update'])->name('professeur.update');
    Route::delete('/{id}', [ProfesseurController::class, 'destroy'])->name('professeur.destroy');
});

Route::get('/login', [ProfesseurController::class, 'showLoginForm'])->name('professeur.login');
Route::post('/login', [ProfesseurController::class, 'login']);
