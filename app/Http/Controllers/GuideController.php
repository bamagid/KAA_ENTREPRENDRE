<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Guides",
 *     description="Endpoints pour la gestion des guides "
 * )
 */
class GuideController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/guides",
     *      operationId="getGuides",
     *      tags={"Guides"},
     *      summary="Récupérer la liste des guides",
     *      description="Récupère la liste de tous les guides",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des guides récupérée avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function index()
    {
        $guides = Guide::all();
    }

    /**
     * @OA\Post(
     *      path="/api/guide/create",
     *      operationId="createGuide",
     *      tags={"Guides"},
     *      summary="Ajouter un nouveau guide",
     *      description="Ajoute un nouveau guide avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="titre", type="string"),
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="phases", type="string"),
     *              @OA\Property(property="reaction", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Guide créé avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function create(Request $request)
    {
        $guides = $request->validate([
            'titre' => 'required',
            'contenu' => 'required',
            'reaction' => 'required',
        ]);

        $guide = new Guide($guides);
        $guide->save();

        return response()->json(['message' => 'Guide ajouté avec succès', 'guide' => $guide], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/guide/update/{id}",
     *      operationId="updateGuide",
     *      tags={"Guides"},
     *      summary="Mettre à jour un guide existant",
     *      description="Met à jour les détails d'un guide existant en fonction de l'ID fourni",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du guide à mettre à jour",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="titre", type="string"),
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="phases", type="string"),
     *              @OA\Property(property="reaction", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Guide mis à jour avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function update(Request $request, string $id)
    {
        $guide = Guide::find($id);
        $guide->titre = $request->titre;
        $guide->contenu = $request->contenu;
        $guide->phases = $request->phases;
        $guide->reaction = $request->reaction;
        $guide->save();

        return response()->json(['message' => 'Guide modifié avec succès', 'guide' => $guide], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/guide/archiver_guide/{id}",
     *      operationId="archiveGuide",
     *      tags={"Guides"},
     *      summary="Archiver un guide",
     *      description="Archive un guide en fonction de l'ID fourni",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID du guide à archiver",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Guide archivé avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function archiver_guide(Request $request, int $id)
    {
        $guide = Guide::find($id);
        $guide->is_deleted = true;
        $guide->save();

        return response()->json(['message' => 'Guide archivé avec succès', 'guide' => $guide], 200);
    }
}
