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
            $etudeCas=$request->validate([

                'contenu'=>'required',
                'image'=>'required',

            ]);
            $etudeCas =new EtudeCas ($etudeCas);

           $etudeCas->contenu=$request->contenu;
           $etudeCas->image=$request->image;
           $etudeCas->user_id=1;
           $etudeCas->secteur_id=1;


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
    public function update(Request $request, EtudeCas $etudeCas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EtudeCas $etudeCas)
    {
        //
    }
}
