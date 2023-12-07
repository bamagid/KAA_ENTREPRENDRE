<?php

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
Route::get('/forums',[ForumController::class,'index']);
//creer un forum
Route::post('/forum/create', [ForumController::class, 'store'])->name('forum.create');
//supprimer un forum
Route::post('/forum/delete', [ForumController::class, 'destroy'])->name('forum.delete');
//modifier un forum
Route::post('forum/edit', [ForumController::class, 'update'])->name('forum.edit');
//afficher le forum selectionne
Route::post('/forum',[ForumController::class,'show'])->name('forum.show');
//archiver une rubrique d'un forum
Route::post('/forum/archiveRubrique', [ForumController::class, 'archiveRubrique'])->name('forum.archiveRubrique');
/* gestion des commentaires du forums */
//lister tous les commentaires d'un forum
Route::get('/commentaires', [CommentaireController::class, 'index']);
//lister  commentaire d'un forum
Route::post('/commentaire', [CommentaireController::class, 'show']);
//ajouter un commentaire a un forum
Route::post('/commentaire/create', [CommentaireController::class, 'store'])->name('comment.add');
//supprimer un commentaire d'un forum
Route::post('/commentaire/delete', [CommentaireController::class, 'destroy'])->name('comment.delete');
//modifier un commentaire d'un forum
Route::post('/commentaire/edit', [CommentaireController::class, 'update'])->name('comment.edit');
//archiver un commentaire de forum
Route::post('/commentaire/archive', [CommentaireController::class, 'archiveCommentaire'])->name('comment.archive');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
