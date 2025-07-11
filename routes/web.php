<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('');
});

// Grouper toutes les routes des professeurs
Route::group(['prefix' => 'client'], function () {
    Route::get('/', [ClientController::class, 'index'])->name('client.index');
    Route::get('/create', [ClientController::class, 'create'])->name('client.create');
    Route::get('/{id}/client', [ClientController::class, 'show'])->name('client.show');
    Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('/{id}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
    Route::post('/store', [ClientController::class, 'store'])->name('client.store');
    
});

Route::get('/login', [ClientController::class, 'showLoginForm'])->name('client.login');
Route::post('/login', [ClientController::class, 'login']);

Route::get('/client/home', [ClientController::class, 'home'])->name('client.home');
Route::get('/client/profile', [ClientController::class, 'profile'])
    ->name('client.profile')
    ->middleware('auth:client');

Route::post('/client/update-photo', [ClientController::class, 'updatePhoto'])
    ->name('client.update.photo')
    ->middleware('auth:client');

Route::post('/client/publier', [PublicationController::class, 'store'])
    ->name('client.publier')
    ->middleware('auth:client');

Route::post('/client/update-releve-bancaire', [ClientController::class, 'updateReleveBancaire'])
    ->name('client.update.releve_bancaire')
    ->middleware('auth:client');

Route::get('/client/searchprofile', [ClientController::class, 'searchprofile'])->name('client.searchprofile');

Route::get('/client/releve-bancaire/{id}', [ClientController::class, 'showReleveBancaire'])->name('client.releve_bancaire');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

