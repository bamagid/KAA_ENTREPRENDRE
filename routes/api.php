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
//lister  reponse d'un forum
Route::post('/reponse', [ReponseController::class, 'show']);
//ajouter un reponse a un forum
Route::post('/reponse/create', [ReponseController::class, 'store'])->name('reponse.add');
//supprimer un reponse d'un forum
Route::post('/reponse/delete', [ReponseController::class, 'destroy'])->name('reponse.delete');
//modifier un reponse d'un forum
Route::post('/reponse/edit', [ReponseController::class, 'update'])->name('reponse.edit');
//archiver un reponse de forum
Route::post('/reponse/archive', [ReponseController::class, 'archivereponse'])->name('reponse.archive');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('ajouter-ressource', [RessourceController::class, 'ajouterRessource'])->name('ajouter-ressource');
Route::put('/ressources/{id}', [RessourceController::class, 'modifierRessource']);
Route::delete('/ressources/{id}', [RessourceController::class, 'supprimerRessource']);
Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class, 'ajouterUtilisateurEntrepreneurExperimente']);
Route::post('/ajouter-utilisateur-admin', [UserController::class, 'ajouterUtilisateurAdmin']);
Route::post('login', [UserController::class, 'login']);
