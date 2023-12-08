<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Ramsey\Uuid\Guid\Guid;

class GuideController extends Controller
{
   // si vous voulez  lister la liste des guides utiliser cette fonction 
    public function index()
    {
        $guides=Guide::all();
        return $guides;

    }

    // cette fonction c'est pour creer guide (ajouter guide)
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

//cette fonction cest pour modifier le guide
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

// cette fonction c'est pour archiver une guide
     public function archiver_guide(Request $request){
        $guide = Guide::find($request->id);
        $guide->is_deleted=true;
        $guide->save();

        return response()->json(['message' => 'guide archiver avec succée', 'guide' => $guide], 200);

     }

}
