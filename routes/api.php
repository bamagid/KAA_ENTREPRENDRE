<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ReponseController;
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


/* gestion des forums*/
//lister les forums
Route::get('/forums', [ForumController::class, 'index']);
//creer un forum
Route::post('/forum/create', [ForumController::class, 'store'])->name('forum.create');
//supprimer un forum
Route::post('/forum/delete', [ForumController::class, 'destroy'])->name('forum.delete');
//modifier un forum
Route::post('forum/edit', [ForumController::class, 'update'])->name('forum.edit');
//afficher le forum selectionne
Route::post('/forum', [ForumController::class, 'show'])->name('forum.show');
//archiver une rubrique d'un forum
Route::post('/forum/archiveRubrique', [ForumController::class, 'archiveRubrique'])->name('forum.archiveRubrique');

/* gestion des commentaires du forums */
//lister tous les commentaires d'un forum
Route::get('/commentaires', [CommentaireController::class, 'index']);
//lister  commentaire d'un forum
Route::post('/commentaire', [CommentaireController::class, 'show']);
//ajouter un commentaire a un forum
Route::post('/commentaire/create', [CommentaireController::class, 'store'])->name('commentaire.add');
//supprimer un commentaire d'un forum
Route::post('/commentaire/delete', [CommentaireController::class, 'destroy'])->name('commentaire.delete');
//modifier un commentaire d'un forum
Route::post('/commentaire/edit', [CommentaireController::class, 'update'])->name('commentaire.edit');
//archiver un commentaire de forum
Route::post('/commentaire/archive', [CommentaireController::class, 'archiveCommentaire'])->name('commentaire.archive');


/* gestion des reponses du forums */
//lister tous les reponses d'un forum
Route::get('/reponses', [ReponseController::class, 'index']);
//lister  une reponse particulier d'un forum
Route::post('/reponse', [ReponseController::class, 'show']);
//ajouter une reponse a un forum
Route::post('/reponse/create', [ReponseController::class, 'store'])->name('reponse.add');
//supprimer une reponse d'un forum
Route::post('/reponse/delete', [ReponseController::class, 'destroy'])->name('reponse.delete');
//modifier une reponse d'un forum
Route::post('/reponse/edit', [ReponseController::class, 'update'])->name('reponse.edit');
//archiver une reponse de forum
Route::post('/reponse/archive', [ReponseController::class, 'archivereponse'])->name('reponse.archive');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Gestion des ressources */
//ajouter une ressource
Route::post('ajouter-ressource', [RessourceController::class, 'ajouterRessource'])->name('ajouter-ressource');
//modifier une ressource
Route::put('/ressources/{id}', [RessourceController::class, 'modifierRessource']);
//supprimer une ressource
Route::delete('/ressources/{id}', [RessourceController::class, 'supprimerRessource']);
//afficher toutes les ressources disponnibles
Route::post('/ressources', [RessourceController::class, 'index']);
//afficher une ressource en particulier
Route::post('/ressource', [RessourceController::class, 'show']);
//archiver une ressource
Route::post('/ressource/archive', [RessourceController::class, 'archiveressource']);

/* Gestion des utilisatueurs  */
//ajouter un role a la table role
Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
//ajouter un utilisateur 'entrepreneur novice'
Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
//ajouter un utilisateur 'entrepreneur experimente'
Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class, 'ajouterUtilisateurEntrepreneurExperimente']);
//ajouter un utilisateur 'admin'
Route::post('/ajouter-utilisateur-admin', [UserController::class, 'ajouterUtilisateurAdmin']);
//se connecter 
Route::post('login', [UserController::class, 'login']);
//se deconnecter 
Route::get('deconnecter',[UserController::class, 'deconnect']);
