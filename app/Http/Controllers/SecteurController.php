<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'nomSecteur' => 'required|string',
        ]);

       
        $secteur = Secteur::create([
            'nomSecteur' => $request->nomSecteur,
            'user_id' => 3, 
        ]);

        return response()->json(['message' => 'Sector created successfully', 'secteur' => $secteur], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Secteur $secteur)
    {
        //
    }
    public function destroy($id)
    {
       
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    

        $secteur = Secteur::find($id);

        if (!$secteur) {
            return response()->json(['message' => 'Secteur not found'], 404);
        }

        $secteur->delete();
    
        return response()->json(['message' => 'Secteur deleted successfully'], 200);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secteur $secteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secteur $secteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    
}
