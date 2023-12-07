<?php

use App\Http\Controllers\RessourceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('ajouter-ressource',[RessourceController::class,'ajouterRessource'])->name('ajouter-ressource');
Route::put('/ressources/{id}', [RessourceController::class, 'modifierRessource']);
    Route::delete('/ressources/{id}', [RessourceController::class, 'supprimerRessource']);
    Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
    Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
    Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class,'ajouterUtilisateurEntrepreneurExperimente']);
    Route::post('/ajouter-utilisateur-admin', [UserController::class,'ajouterUtilisateurAdmin']);
    Route::post('login', [UserController::class, 'login']);