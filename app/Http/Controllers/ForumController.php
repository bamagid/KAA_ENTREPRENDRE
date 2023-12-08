<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = Forum::where('is_deleted', 0)->get();
        return $forums;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nomRubrique' => 'required|string|min:3',
                'user_id' => 'required|numeric',
            ]

        );
        $user=Auth::user();
        if ($user->role_id===1){
        Forum::create(
            [
                'rubrique' => $request->nomRubrique,
                'user_id' => $request->input('user_id')
            ]
        );
        return response()->json(['message' => "La rubrique est bien ajoutée"]);
        }else{
            return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $forum = Forum::findOrFail($request->input('id'));
        if ($forum) {
            return $forum;
        }
        //    return response()->json(['message'=>"La rubrique est bien supprimé"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Forum $forum)
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
                'nomRubrique' => 'required|string|min:3',
                'user_id' => 'required|numeric',
                'id' => 'required|numeric'
            ]
        );
        $user=Auth::user();
        if ($user->role_id===1){
        $forum = Forum::findOrFail($request->input('id'));
        $forum->rubrique = $request->nomRubrique;
        $forum->update();
        return response()->json(['message' => "La rubrique est bien modifiée"]);
    }else{
        return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function archiveRubrique(Request $request)
    {
        $user=Auth::user();
        if ($user->role_id===1){
        $forum = Forum::findOrFail($request->input('id'));
        $forum->is_deleted=true;
        $forum->update();
        return response()->json(['message' => "La rubrique a été bien archivé"]);
    }else{
        return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        if ($user->role_id===1){
        $forum = Forum::findOrFail($request->input('id'));
        $forum->delete();
        return response()->json(['message' => "La rubrique est bien supprimé"]);
    }else{
        return response()->json(['error'=>"Vous n'avez pas les droits pour effectuer cette action"],401);
        }
    }
}
