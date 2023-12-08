<?php

namespace App\Http\Controllers;

use App\Models\Ressource;
use Illuminate\Http\Request;

class RessourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $ressources = Ressource::where('is_deleted', 0)->get();
        return $ressources;
    }
    public function ajouterRessource(Request $request)
    {
        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'lien' => 'required|string',
        ]);

        // Gestion du téléchargement de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

        // Vérification de l'authentification de l'utilisateur
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }

        // Création de la ressource
        $ressource = new Ressource([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $imagePath,
            'lien' => $request->lien,
        ]);

        // Attribution de l'ID de l'utilisateur à la ressource
        $ressource->user_id = $user->id;

        // Sauvegarde de la ressource
        $ressource->save();

        // Réponse JSON
        return response()->json(['message' => 'Ressource ajoutée avec succès'], 201);
    }


    public function modifierRessource(Request $request, $id)
    {
        if (!auth()->user()) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }

        $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'lien' => 'required|string',
        ]);

        $ressource = Ressource::find($id);

        if (!$ressource) {
            return response()->json(['message' => 'Ressource non trouvée'], 404);
        }
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
        $ressource->fill([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' =>  $imagePath,
            'lien' => $request->lien,
        ]);
    
        return response()->json(['message' => 'Ressource modifiée avec succès'], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function supprimerRessource($id)
    {

        if (!auth()->user()) {
            return response()->json(['message' => 'Utilisateur non authentifié'], 401);
        }

        $ressource = Ressource::find($id);

        if (!$ressource) {
            return response()->json(['message' => 'Ressource non trouvée'], 404);
        }



        $ressource->delete();

        return response()->json(['message' => 'Ressource supprimée avec succès'], 200);
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
        $ressource=Ressource::findOrFail($request->id);
        return $ressource;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ressource $ressource)
    {
        //
    }

    /**
     * Archive the specified resource in storage.
     */
    public function archive(Request $request)
    {
        $ressource=Ressource::findOrFail($request->id);
        $ressource->is_deleted=true;
        $ressource->save();
        return $ressource;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ressource $ressource)
    {
        //
    }
}
