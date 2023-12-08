<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentaires=Commentaire::where('is_deleted', 0)->get();
        return $commentaires;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'contenu' => 'required|string|min:3',
            ]

        );
        Commentaire::create(
            [
                'contenu' => $request->contenu,
                'user_id' =>Auth::user()->id,
            ]
        );
        return response()->json(['message' => "Le commentaire est bien ajouté"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
         $commentaire = Commentaire::findOrFail($request->input('id'));
        if ($commentaire) {
            return $commentaire;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'contenu' => 'required|string|min:3',
                'id' => 'required|numeric'
            ]
        );
        $commentaire = Commentaire::findOrFail($request->input('id'));
        if ($commentaire->user_id===Auth::user()->id) {
            $commentaire->contenu = $request->contenu;
            $commentaire->update();
            return response()->json(['message' => "Le commentaire est bien modifié"]);
        }
        else{
            return response()->json(['error'=>"Vous n'avez pas le droit de modifier ce commentaire"],401);
            }
            
    }
    /**
     * Archive the specified resource in storage.
     */
    public function archiveCommentaire(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|numeric',
                'id' => 'required|numeric'
            ]
        );
        $commentaire = Commentaire::findOrFail($request->input('id'));
        if ($commentaire->user_id===Auth::user()->id) {
        $commentaire->is_deleted=true;
        $commentaire->update();
        return response()->json(['message' => "Le commentaire est bien archivé"]);
        }else{
            return response()->json(['error'=>"Vous n'avez pas le droit de supprimer ce commentaire"],401);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user=Auth::user()->id;
        if ($user->role_id===1){
        $commentaire = Commentaire::findOrFail($request->input('id'));
        $commentaire->delete();
        return response()->json(['message' => "La commentaire est bien supprimé"]);
    }else{
        return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
        }
    }
}
