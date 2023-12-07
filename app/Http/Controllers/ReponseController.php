<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use App\Models\User;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reponses=Reponse::where('is_deleted', 0)->get();
        return $reponses;
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
                'user_id' => 'required|numeric',
                'commentaire_id' => 'required|numeric',
            ]

        );
        Reponse::create(
            [
                'contenu' => $request->contenu,
                'user_id' => $request->input('user_id'),
                'commentaire_id' => $request->input('commentaire_id')
            ]
        );
        return response()->json(['message' => "La reponse est bien ajouté"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
         $reponse = Reponse::findOrFail($request->input('id'));
        if ($reponse && $reponse->is_deleted===0) {
            return $reponse;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reponse $Reponse)
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
                'user_id' => 'required|numeric',
                'id' => 'required|numeric'
            ]
        );
        $reponse = Reponse::findOrFail($request->input('id'));
        if ($reponse->user_id===$request->user_id) {
            $reponse->contenu = $request->contenu;
            $reponse->update();
            return response()->json(['message' => "La reponse est bien modifié"]);
        }
        else{
            return response()->json(['error'=>"Vous n'avez pas le droit de modifier cette reponse"],401);
            }
            
    }
    /**
     * Archive the specified resource in storage.
     */
    public function archiveReponse(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|numeric',
                'id' => 'required|numeric'
            ]
        );
        $reponse = Reponse::findOrFail($request->input('id'));
        if ($reponse->user_id===$request->user_id) {
        $reponse->is_deleted=true;
        $reponse->update();
        return response()->json(['message' => "La reponse est bien archivé"]);
        }else{
            return response()->json(['error'=>"Vous n'avez pas le droit de supprimer cette reponse"],401);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        if ($user->role_id===1){
        $reponse = Reponse::findOrFail($request->input('id'));
        $reponse->delete();
        return response()->json(['message' => "La reponse est bien supprimé"]);
    }else{
        return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
        }
    }
}
