<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ActualiteController;
use App\Http\Controllers\Admin\AnneeAcademiqueController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcueController;
use App\Http\Controllers\Admin\NiveauController;
use App\Http\Controllers\Admin\RessourceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TypeRessourceController;
use App\Http\Controllers\Admin\UeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ActualiteRechercheController;
use App\Http\Controllers\ArborescenceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RessourceRechercheController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/actualites', [ActualiteRechercheController::class, 'index'])->name('actualites.index');
Route::get('/actualites/{actualite}', [ActualiteRechercheController::class, 'show'])->name('actualites.show');

Route::middleware(['auth', 'permission:gerer-ressources|gerer-referentiels|gerer-utilisateurs|gerer-roles|gerer-actualites|voir-statistiques'])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
    });

Route::middleware(['auth', 'permission:gerer-referentiels'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('annees-academiques', AnneeAcademiqueController::class);
    Route::resource('niveaux', NiveauController::class);
    Route::resource('ues', UeController::class);
    Route::resource('ecues', EcueController::class);
    Route::resource('types-ressources', TypeRessourceController::class);
});

Route::middleware(['auth', 'permission:gerer-ressources'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('ressources', RessourceController::class);
    Route::patch('ressources/{ressource}/publish', [RessourceController::class, 'publish'])->name('ressources.publish');
    Route::patch('ressources/{ressource}/retract', [RessourceController::class, 'retract'])->name('ressources.retract');
});

Route::middleware(['auth', 'permission:gerer-utilisateurs'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.removeRole');
});

Route::middleware(['auth', 'permission:gerer-roles'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'permission:gerer-actualites'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('actualites', ActualiteController::class);
    Route::patch('actualites/{actualite}/publish', [ActualiteController::class, 'publish'])->name('actualites.publish');
    Route::patch('actualites/{actualite}/retract', [ActualiteController::class, 'retract'])->name('actualites.retract');
});

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/ressources/arborescence', [ArborescenceController::class, 'index'])->name('arborescence.index');
    Route::get('/ressources/arborescence/{anneeAcademique}/niveaux', [ArborescenceController::class, 'niveaux'])->name('arborescence.niveaux');
    Route::get('/ressources/arborescence/{anneeAcademique}/niveaux/{niveau}/ues', [ArborescenceController::class, 'ues'])->name('arborescence.ues');
    Route::get('/ressources/arborescence/{anneeAcademique}/niveaux/{niveau}/ues/{ue}/ecues', [ArborescenceController::class, 'ecues'])->name('arborescence.ecues');
    Route::get('/ressources/arborescence/{anneeAcademique}/niveaux/{niveau}/ues/{ue}/ressources/{ecue?}', [ArborescenceController::class, 'ressources'])->name('arborescence.ressources');

    Route::get('/ressources/ues-par-niveau/{niveau}', [RessourceRechercheController::class, 'uesParNiveau'])->name('ressources.uesParNiveau');
    Route::get('/ressources/ecues-par-ue/{ue}', [RessourceRechercheController::class, 'ecuesParUe'])->name('ressources.ecuesParUe');
    Route::get('/ressources', [RessourceRechercheController::class, 'index'])->name('ressources.index');
    Route::get('/ressources/{ressource}', [RessourceRechercheController::class, 'show'])->name('ressources.show');
    Route::get('/ressources/{ressource}/preview', [RessourceRechercheController::class, 'preview'])->name('ressources.preview');
    Route::get('/ressources/{ressource}/download', [RessourceRechercheController::class, 'download'])->name('ressources.download');
});
