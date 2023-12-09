<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Réponses",
 *     description="Endpoints pour la gestion des réponses "
 * )
 */
class ReponseController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/reponses",
     *      operationId="getReponses",
     *      tags={"Réponses"},
     *      summary="Récupérer la liste des réponses",
     *      description="Récupère la liste de toutes les réponses",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des réponses récupérée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function index()
    {
        $reponses = Reponse::where('is_deleted', 0)->get();
        return $reponses;
    }

    /**
     * @OA\Post(
     *      path="/api/reponse/create",
     *      operationId="createReponse",
     *      tags={"Réponses"},
     *      summary="Ajouter une nouvelle réponse",
     *      description="Ajoute une nouvelle réponse avec les détails fournis",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="commentaire_id", type="numeric"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Réponse ajoutée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|min:3',
            'commentaire_id' => 'required|numeric',
        ]);

        Reponse::create([
            'contenu' => $request->contenu,
            'user_id' => auth()->user()->id,
            'commentaire_id' => $request->input('commentaire_id'),
        ]);

        return response()->json(['message' => "La réponse a bien été ajoutée"]);
    }

    /**
     * @OA\Post(
     *      path="/api/reponse/edit",
     *      operationId="updateReponse",
     *      tags={"Réponses"},
     *      summary="Mettre à jour une réponse existante",
     *      description="Met à jour les détails d'une réponse existante",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="id", type="numeric"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Réponse mise à jour avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function update(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|min:3',
            'id' => 'required|numeric',
        ]);

        $reponse = Reponse::findOrFail($request->input('id'));
        if ($reponse->user_id === auth()->user()->id) {
            $reponse->contenu = $request->contenu;
            $reponse->update();
            return response()->json(['message' => "La réponse a bien été modifiée"]);
        } else {
            return response()->json(['error' => "Vous n'avez pas le droit de modifier cette réponse"], 401);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/reponse/archive",
     *      operationId="archiveReponse",
     *      tags={"Réponses"},
     *      summary="Archiver une réponse",
     *      description="Archive une réponse en fonction de l'ID fourni",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="numeric"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Réponse archivée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function archivereponse(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        $reponse = Reponse::findOrFail($request->input('id'));
        if ($reponse->user_id === auth()->user()->id) {
            $reponse->is_deleted = true;
            $reponse->update();
            return response()->json(['message' => "La réponse a bien été archivée"]);
        } else {
            return response()->json(['error' => "Vous n'avez pas le droit de supprimer cette réponse"], 401);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/reponse/delete",
     *      operationId="destroyReponse",
     *      tags={"Réponses"},
     *      summary="Supprimer une réponse",
     *      description="Supprime une réponse en fonction de l'ID fourni",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="numeric"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Réponse supprimée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id === 1) {
            $request->validate([
                'id' => 'required|numeric',
            ]);

            $reponse = Reponse::findOrFail($request->input('id'));
            $reponse->delete();
            return response()->json(['message' => "La réponse a bien été supprimée"]);
        } else {
            return response()->json(['error' => "Vous n'avez pas les droits pour effectuer cette action"], 401);
        }
    }
}
