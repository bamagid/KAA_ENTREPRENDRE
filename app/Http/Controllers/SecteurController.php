<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
 /**
     * @OA\Tag(
     *     name="Secteurs",
     *     description="Endpoints pour la gestion des secteurs."
     * )
     */
class SecteurController extends Controller
{
     

    /**
     * @OA\Get(
     *      path="/api/Secteurs",
     *      operationId="getSecteurs",
     *      tags={"Secteurs"},
     *      summary="Obtenir la liste des secteurs",
     *      description="Récupère la liste de toutes les secteurs non supprimées.",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des secteurs récupérée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
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
            'user_id' => 1,
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
