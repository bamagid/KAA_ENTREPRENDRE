<?php

use App\Http\Controllers\EtudeCasController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\GuideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\RessourceController;

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


    Route::post('/ajouter-role', [UserController::class, 'ajouterRole']);
    Route::post('/ajouter-utilisateur-entrepreneur-novice', [UserController::class, 'ajouterUtilisateurEntrepreneurNovice']);
    Route::post('/ajouter-utilisateur-entrepreneur-experimente', [UserController::class,'ajouterUtilisateurEntrepreneurExperimente']);
    Route::post('/ajouter-utilisateur-admin', [UserController::class,'ajouterUtilisateurAdmin']);
    Route::post('login', [UserController::class, 'login']);
