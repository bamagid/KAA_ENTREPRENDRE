<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Ramsey\Uuid\Guid\Guid;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides=Guide::all();

    }


    /**
     * Display the specified resource.
     */
    public function create(Request $request)
    {
       
        $guides=$request->validate([
            'titre' => 'required',
            'contenu'=>'required',
            'phases'=>'required',
            'reaction'=>'required',
        ]);
        $guide =new Guide($guides);
        $guide->save();

        return response()->json(['message' => 'guide ajouter avec succée', 'guide' => $guide], 200);


    }


    public function update(Request $request, string $id)
    {
        $guide = Guide::find($id);
        $guide->titre=$request->titre;
        $guide->contenu=$request->contenu;
        $guide->phases=$request->phases;
        $guide->reaction=$request->reaction;
        $guide->save();

        return response()->json(['message' => 'guide modifer avec succée', 'guide' => $guide], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

}
