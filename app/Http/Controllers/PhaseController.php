<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Phases",
 *     description="Endpoints pour la gestion des phases "
 * )
 */
class phaseController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/phases",
     *      operationId="getPhases",
     *      tags={"Phases"},
     *      summary="Récupérer la liste des phases",
     *      description="Récupère la liste de toutes les phases",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des phases récupérée avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function index()
    {
        $phases = Phase::all();
    }

    /**
     * @OA\Post(
     *      path="/api/phase/create",
     *      operationId="createphase",
     *      tags={"phases"},
     *      summary="Ajouter une nouvelle phase",
     *      description="Ajoute une nouvelle phase avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="titre", type="string"),
     *              @OA\Property(property="description", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="phase créé avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function create(Request $request)
    {
        $phases = $request->validate([
            'titre' => 'required',
            'description' => 'required',
        ]);

        $phase = new phase($phases);
        $phase->save();

        return response()->json(['message' => 'phase ajouté avec succès', 'phase' => $phase], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/phase/update_phase/{id}",
     *      operationId="updatephase",
     *      tags={"phases"},
     *      summary="Mettre à jour une phase existant",
     *      description="Met à jour les détails d'une phase existant en fonction de l'ID fourni",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID de la phase à mettre à jour",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="titre", type="string"),
     *              @OA\Property(property="description", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="phase mise à jour avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function update(Request $request, string $id)
    {
        $phase = phase::find($id);
        $phase->titre = $request->titre;
        $phase->description = $request->description;
        $phase->save();

        return response()->json(['message' => 'phase modifié avec succès', 'phase' => $phase], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/phase/archiver_phase/{id}",
     *      operationId="archivephase",
     *      tags={"phases"},
     *      summary="Archiver une phase",
     *      description="Archive une phase en fonction de l'ID fourni",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du phase à archiver",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="phase archivé avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function archiver_phase(Request $request, int $id)
    {
        $phase = phase::find($id);
        $phase->is_deleted = true;
        $phase->save();

        return response()->json(['message' => 'phase archivé avec succès', 'phase' => $phase], 200);
    }
}
