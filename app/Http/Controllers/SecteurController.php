<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @OA\Post(
     *      path="/api/secteur/create",
     *      operationId="createsecteur",
     *      tags={"Secteurs"},
     *      summary="Ajouter un nouveau secteur",
     *      description="Ajoute un nouveau secteur avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nomSecteur", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Secteur créé avec succès",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non autorisé",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function store(Request $request)
    {

        $request->validate([
            'nomSecteur' => 'required|string',
        ]);


        $secteur = Secteur::create([
            'nomSecteur' => $request->nomSecteur,
            'user_id' => Auth::user()->id,
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

     /**
     * @OA\Post(
     *      path="/api/secteur/destroy",
     *      operationId="destroysecteur",
     *      tags={"secteurs"},
     *      summary="Supprimer un secteur",
     *      description="Supprime un secteur en fonction de l'ID fourni",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="secteur supprimé avec succès",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Non autorisé",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
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
