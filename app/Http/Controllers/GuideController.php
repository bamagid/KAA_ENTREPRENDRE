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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $guides=$request->validate([
            'titre' => 'required',
            'contenu'=>'required',
            'phase'=>'required',
              'reaction'=>'required',
        ]);
        $guide =new Guide($guides);
       $guide->titre = $request->titre;
       $guide->contenu=$request->contenu;
       $guide->phase=$request->phase;
       $guide->reaction=$request->reaction;
        $guide->save();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guide $guide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        //
    }
}
