<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\PublicationController;

Route::get('/', function () {
    return view('');
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

Route::get('/professeur/home', [ProfesseurController::class, 'home'])->name('professeur.home');
Route::get('/professeur/profile', [ProfesseurController::class, 'profile'])
    ->name('professeur.profile')
    ->middleware('auth:professeur');

Route::post('/professeur/update-photo', [ProfesseurController::class, 'updatePhoto'])
    ->name('professeur.update.photo')
    ->middleware('auth:professeur');

Route::post('/professeur/publier', [PublicationController::class, 'store'])
    ->name('professeur.publier')
    ->middleware('auth:professeur');


