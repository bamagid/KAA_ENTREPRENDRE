<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\NewsletterSubscriptionController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function(){
    Route::post('ajouter-ressource',[RessourceController::class,'ajouterRessource'])->name('ajouter-ressource');
    Route::post('/ressources/{id}', [RessourceController::class, 'modifierRessource']);
    Route::delete('/ressources/{id}', [RessourceController::class, 'supprimerRessource']);

    //route pour evenement 
    Route::get('/events', [EvenementController::class, 'index']);
Route::get('/events/{id}', [EvenementController::class, 'show']);
Route::post('/events', [EvenementController::class, 'store']);
Route::post('/events/{id}', [EvenementController::class, 'update']);
Route::delete('/events/{id}', [EvenementController::class, 'destroy']);
Route::post('/secteurs', [SecteurController::class, 'store']);
Route::delete('/secteurs/{id}', [SecteurController::class, 'destroy']);
});

Route::middleware('auth:api')->post('/entrepreneur-novice/profile', [UserController::class,'updateProfile']);
Route::middleware('auth:api')->post('/entrepreneur-experimente/profile', [UserController::class,'updateProfileExperimente']);
Route::middleware('auth:api')->post('/admin/profile',[UserController::class,'UpdateAdmin']);
Route::middleware(['auth:api', 'admin'])->post('/admin/block-account/{userId}', [UserController::class,'toggleBlockAccount']);
    Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);

Route::post('/modifier-mot-de-passe', [UserController::class,'modifierMotDePasse'])->middleware('auth:api');
Route::post('/reinitialiser-mot-de-passe', [UserController::class,'reinitialiserMotDePasse'])->middleware('auth:api');

    Route::middleware(['web', 'auth', 'checkStatus'])->group(function () {
        // mes routes quand lutilisateur est bloquer pour lui interdire certiane partied du site
    });
    Route::post('/subscribe-newsletter', [NewsletterSubscriptionController::class, 'subscribe']);
    Route::get('/search',[SearchController::class,'search']);
    Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
    Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class,'ajouterUtilisateurEntrepreneurExperimente']);
    Route::post('/ajouter-utilisateur-admin', [UserController::class,'ajouterUtilisateurAdmin']);
    Route::post('login', [UserController::class, 'login']);