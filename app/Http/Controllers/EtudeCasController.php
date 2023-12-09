<?php

namespace App\Http\Controllers;

use App\Models\EtudeCas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="EtudeCas",
 *     description="Endpoints pour la gestion des etudes de cas"
 * )
 */

class EtudeCasController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/etude-cas/create/{id}",
     *      operationId="createEtudeCas",
     *      tags={"EtudeCas"},
     *      summary="Ajouter une nouvelle étude de cas",
     *      description="Ajoute une nouvelle étude de cas avec les détails fournis",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID du secteur",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="secteur_id", type="integer")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Etude de cas ajoutée avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
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

        $etudeCas = new EtudeCas($etudeCas);
        $etudeCas->contenu = $request->contenu;
        $etudeCas->image = $imagePath;
        $etudeCas->user_id = FacadesAuth::user()->id;
        $etudeCas->secteur_id = $request->secteur_id;

        $etudeCas->save();

        return response()->json(['message' => 'etudeCas ajoutée avec succès', 'etudeCas' => $etudeCas], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/etude-cas/update_etudeCas",
     *      operationId="updateEtudeCas",
     *      tags={"EtudeCas"},
     *      summary="Modifier une étude de cas existante",
     *      description="Modifie les détails d'une étude de cas existante avec les données fournies",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="contenu", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="secteur_id", type="integer")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Etude de cas modifiée avec succès")
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
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
        $etudeCas->contenu = $request->contenu;
        $etudeCas->image = $imagePath;
        $etudeCas->user_id = FacadesAuth::user()->id;
        $etudeCas->secteur_id = $request->secteur_id;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas modifiée avec succès', 'etudecas' => $etudeCas], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/etude-cas/archive/{id}",
     *      operationId="archiveEtudeCas",
     *      tags={"EtudeCas"},
     *      summary="Archiver une étude de cas",
     *      description="Archive une étude de cas spécifique",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de l'étude de cas",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Etude de cas archivée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function archive(Request $request)
    {
        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->is_deleted = true;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas archivée avec succès', 'etudecas' => $etudeCas], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/etude-cas/delete/{id}",
     *      operationId="deleteEtudeCas",
     *      tags={"EtudeCas"},
     *      summary="Supprimer une étude de cas",
     *      description="Supprime une étude de cas spécifique",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID de l'étude de cas",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Etude de cas supprimée avec succès",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function delete(Request $request)
    {
        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->delete();

        return response()->json(['message' => 'etude cas supprimée avec succès', 'etudecas' => $etudeCas], 200);
    }
}
