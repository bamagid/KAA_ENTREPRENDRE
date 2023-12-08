<?php

namespace App\Http\Controllers;

use App\Models\EtudeCas;
use Illuminate\Http\Request;

class EtudeCasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */


        public function create(Request $request)
        {

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images', $imageName, 'public');
            }

            $etudeCas=$request->validate([

                'contenu'=>'required',
                'image'=>'required',

            ]);
            $etudeCas =new EtudeCas ($etudeCas);

           $etudeCas->contenu=$request->contenu;
           $etudeCas->$imagePath=$request->$imagePath;
           $etudeCas->user_id=$request->user_id;
           $etudeCas->secteur_id=$request->secteur_id;


            $etudeCas->save();

            return response()->json(['message' => 'etudeCas ajouter avec succée', 'etudeCas' => $etudeCas], 200);


        }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EtudeCas $etudeCas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EtudeCas $etudeCas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }


        $etudeCas = EtudeCas::find($request->id);
        // dd($etudeCas);
        $etudeCas->contenu=$request->contenu;
        $etudeCas->image=$imagePath;
        $etudeCas->user_id=$request->user_id;
        $etudeCas->secteur_id=$request->secteur_id;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas modifer avec succée', 'etudecas' => $etudeCas], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function archive(Request $request){

        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->is_deleted=true;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas archiver avec succée', 'etudecas' => $etudeCas], 200);
    }


    public function delete(Request $request)
    {
        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->delete();

        return response()->json(['message' => 'etude cas supprimer avec succée', 'etudecas' => $etudeCas], 200);
    }
}
