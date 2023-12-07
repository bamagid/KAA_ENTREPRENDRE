<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums=Forum::where('is_deleted',0)->get();
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
                'nomRubrique'=>'required|string|min:3',
                'user_id'=>'required|numeric',
                ]
                
            );
    Forum::create(
            [
                'rubrique'=>$request->nomRubrique,
                'user_id'=>$request->input('user_id')
                ]
            );
            return response()->json(['message'=>"La rubrique est bien ajoutée"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Forum $forum)
    {
        //
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
            'nomRubrique'=>'required|string|min:3',
            'user_id'=>'required|numeric',
            'id'=>'required|numeric'
            ]  
        );
        $forum = Forum::findOrFail($request->input('id'));
        $forum->rubrique=$request->nomRubrique;
        $forum->update();
        return response()->json(['message'=>"La rubrique est bien modifiée"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
      $forum = Forum::findOrFail($request->input('id'));
       $forum->delete();
       return response()->json(['message'=>"La rubrique est bien supprimé"]);
    }
}
