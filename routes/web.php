<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\AuthController;

// Page d'accueil - Redirection vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Routes de réinitialisation du mot de passe
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.update');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');


// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    
    // Tableau de bord
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Gestion des étudiants
    Route::prefix('etudiants')->name('etudiants.')->group(function () {
        Route::get('/', [EtudiantController::class, 'index'])->name('index');
        Route::get('/create', [EtudiantController::class, 'create'])->name('create');
        Route::post('/', [EtudiantController::class, 'store'])->name('store');
        Route::get('/{etudiant}', [EtudiantController::class, 'show'])->name('show');
        Route::delete('/{etudiant}', [EtudiantController::class, 'destroy'])->name('destroy');
        Route::get('/inscription/{inscription}/recu', [EtudiantController::class, 'recu'])->name('recu');
    });

    // Gestion des paiements
    Route::prefix('paiements')->name('paiements.')->group(function () {
        Route::get('/', [PaiementController::class, 'index'])->name('index');
        Route::get('/create', [PaiementController::class, 'create'])->name('create');
        Route::post('/', [PaiementController::class, 'store'])->name('store');
        Route::get('/{paiement}/recu', [PaiementController::class, 'recu'])->name('recu');
        // Route::get('/{paiement}/imprimer', [PaiementController::class, 'imprimer'])->name('imprimer');
    });

    // Gestion des besoins
    Route::prefix('besoins')->name('besoins.')->group(function () {
        Route::get('/', [BesoinController::class, 'index'])->name('index');
        Route::get('/create', [BesoinController::class, 'create'])->name('create');
        Route::post('/', [BesoinController::class, 'store'])->name('store');
        Route::get('/{besoin}', [BesoinController::class, 'show'])->name('show');
        Route::get('/{besoin}/edit', [BesoinController::class, 'edit'])->name('edit');
        Route::put('/{besoin}', [BesoinController::class, 'update'])->name('update');
    });

});
