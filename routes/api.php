<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\EtudeCasController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\GuideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\ForumController;
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
//lister les forums
Route::get('/forums', [ForumController::class, 'index']);
Route::get('/events', [EvenementController::class, 'index']);
//lister tous les commentaires d'un forum
Route::get('/commentaires', [CommentaireController::class, 'index']);
//lister  commentaire d'un forum
Route::post('/commentaire', [CommentaireController::class, 'show']);
//lister toutes les reponses d'un forum
Route::get('/reponses', [ReponseController::class, 'index']);
//lister  une reponse particulier d'un forum
Route::post('/reponse', [ReponseController::class, 'show']);
//afficher le forum selectionne
Route::post('/forum', [ForumController::class, 'show'])->name('forum.show');
Route::get('/events/{id}', [EvenementController::class, 'show']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->group(function () {
    /* gestion des commentaires du forums */
    //ajouter un commentaire a un forum
    Route::post('/commentaire/create', [CommentaireController::class, 'store'])->name('commentaire.add');

    //modifier un commentaire d'un forum
    Route::post('/commentaire/edit', [CommentaireController::class, 'update'])->name('commentaire.edit');
    //archiver un commentaire de forum
    Route::post('/commentaire/archive', [CommentaireController::class, 'archiveCommentaire'])->name('commentaire.archive');


    /* gestion des reponses du forums */
    //ajouter une reponse a un forum
    Route::post('/reponse/create', [ReponseController::class, 'store'])->name('reponse.add');

    //modifier une reponse d'un forum
    Route::post('/reponse/edit', [ReponseController::class, 'update'])->name('reponse.edit');
    //archiver une reponse de forum
    Route::post('/reponse/archive', [ReponseController::class, 'archivereponse'])->name('reponse.archive');



    /* Gestion des utilisatueurs  */
    //modification du profile d'un entrepreneur novice
    Route::post('/entrepreneur-novice/profile', [UserController::class, 'updateProfile']);
    //modification du profile d'un entrepreneur eperimenté
    Route::post('/entrepreneur-experimente/profile', [UserController::class, 'updateProfileExperimente']);
});

//blockage d'un utilisateur par l'admin
Route::middleware(['auth:api', 'admin'])->group(function () {
    /* gestion des forums*/

    //creer un forum
    Route::post('/forum/create', [ForumController::class, 'store'])->name('forum.create');
    //supprimer un forum
    Route::post('/forum/delete', [ForumController::class, 'destroy'])->name('forum.delete');
    //modifier un forum
    Route::post('forum/edit', [ForumController::class, 'update'])->name('forum.edit');
    //archiver une rubrique d'un forum
    Route::post('/forum/archiveRubrique', [ForumController::class, 'archiveRubrique'])->name('forum.archiveRubrique');


    //supprimer un commentaire d'un forum
    Route::post('/commentaire/delete', [CommentaireController::class, 'destroy'])->name('commentaire.delete');

    //supprimer une reponse d'un forum
    Route::post('/reponse/delete', [ReponseController::class, 'destroy'])->name('reponse.delete');

    //modification du profile d'un admin
    Route::post('/admin/profile', [UserController::class, 'UpdateAdmin']);

    //ajouter un role a la table role
    Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);

    /* Gestion des ressources */
    //ajouter une ressource
    Route::post('ajouter-ressource', [RessourceController::class, 'ajouterRessource'])->name('ajouter-ressource');
    //modifier une ressource
    Route::post('/ressources/{id}', [RessourceController::class, 'modifierRessource']);
    //supprimer une ressource
    Route::delete('/ressources/{id}', [RessourceController::class, 'supprimerRessource']);
    //afficher toutes les ressources disponnibles
    Route::post('/ressources', [RessourceController::class, 'index']);
    //afficher une ressource en particulier
    Route::post('/ressource', [RessourceController::class, 'show']);
    //archiver une ressource
    Route::post('/ressource/archive', [RessourceController::class, 'archiveressource']);

    Route::post('ajouter-ressource', [RessourceController::class, 'ajouterRessource'])->name('ajouter-ressource');

    /* Gestion des evenements */
    //route pour evenement

    Route::get('/events', [EvenementController::class, 'index']);
    Route::post('/events_add', [EvenementController::class, 'store']);
    Route::post('/events/{id}', [EvenementController::class, 'update']);
    Route::delete('/events/{id}', [EvenementController::class, 'destroy']);
    Route::post('/secteurs', [SecteurController::class, 'store']);
    Route::delete('/secteurs/{id}', [SecteurController::class, 'destroy']);
});

Route::middleware(['web', 'auth', 'checkStatus'])->group(function () {
    // mes routes quand lutilisateur est bloquer pour lui interdire certaine partie du site
});
//ajouter un utilisateur 'entrepreneur novice'
Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
//ajouter un utilisateur 'entrepreneur experimente'
Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class, 'ajouterUtilisateurEntrepreneurExperimente']);
//ajouter un utilisateur 'admin'
Route::post('/ajouter-utilisateur-admin', [UserController::class, 'ajouterUtilisateurAdmin']);
//se connecter
Route::post('login', [UserController::class, 'login']);
//se deconnecter
Route::get('deconnecter', [UserController::class, 'deconnect']);




//ajouter guide
Route::post('/create_guide', [GuideController::class, 'create']);
//afficher guide
Route::get('/index', [GuideController::class, 'index']);
//modifier le guide
Route::post('/update/{id}', [GuideController::class, 'update']);
//archiver un guide
Route::post('/archiver_guide/{id}', [GuideController::class, 'archiver_guide']);

/** Gestion des phases d'un guide */
//ajouter phase
Route::post('/create_phase', [phaseController::class, 'create']);
//afficher phase
Route::get('/index', [phaseController::class, 'index']);
//modifier le phase
Route::post('/update_phase/{id}', [phaseController::class, 'update']);
//archiver un phase
Route::post('/archiver_phase/{id}', [phaseController::class, 'archiver_phase']);
Route::post('/modifier-mot-de-passe', [UserController::class,'modifierMotDePasse'])->middleware('auth:api');
Route::post('/reinitialiser-mot-de-passe', [UserController::class,'reinitialiserMotDePasse'])->middleware('auth:api');
Route::middleware('auth:api')->post('/entrepreneur-novice/profile', [UserController::class,'updateProfile']);
Route::middleware('auth:api')->post('/entrepreneur-experimente/profile', [UserController::class,'updateProfileExperimente']);
Route::middleware('auth:api')->post('/admin/profile',[UserController::class,'UpdateAdmin']);
Route::middleware(['auth:api', 'admin'])->post('/admin/block-account/{userId}', [UserController::class,'toggleBlockAccount']);
    Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);

    Route::middleware(['web', 'auth', 'checkStatus'])->group(function () {
        // mes routes quand lutilisateur est bloquer pour lui interdire certiane partied du site
    });

    Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
    Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class,'ajouterUtilisateurEntrepreneurExperimente']);
    Route::post('/ajouter-utilisateur-admin', [UserController::class,'ajouterUtilisateurAdmin']);
    Route::post('login', [UserController::class, 'login']);

    Route::post('verifMail',[UserController::class,'verifMail']);
    Route::post('resetPassword/{user}',[UserController::class,'resetPassword']);
