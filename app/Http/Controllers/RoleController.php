<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
 /**
     * @OA\Tag(
     *     name="Roles",
     *     description="Endpoints pour la gestion des rôles."
     * )
     */
class RoleController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/roles",
     *      operationId="getRoles",
     *      tags={"Roles"},
     *      summary="Obtenir la liste des rôles",
     *      description="Récupère la liste de tous les rôles.",
     *      @OA\Response(
     *          response=200,
     *          description="Liste des rôles récupérée avec succès"
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
     * @OA\Post(
     *      path="/api/roles",
     *      operationId="createRole",
     *      tags={"Roles"},
     *      summary="Créer un nouveau rôle",
     *      description="Crée un nouveau rôle avec les détails fournis.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nom", type="string"),
     *              @OA\Property(property="description", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Rôle créé avec succès"
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/roles/{role}",
     *      operationId="getRoleById",
     *      tags={"Roles"},
     *      summary="Obtenir un rôle par ID",
     *      description="Récupère les détails d'un rôle spécifique en fonction de l'ID fourni.",
     *      @OA\Parameter(
     *          name="role",
     *          description="ID du rôle",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Détails du rôle récupérés avec succès"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Rôle non trouvé",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/roles/{role}",
     *      operationId="updateRole",
     *      tags={"Roles"},
     *      summary="Mettre à jour un rôle existant",
     *      description="Met à jour les détails d'un rôle existant en fonction de l'ID fourni.",
     *      @OA\Parameter(
     *          name="role",
     *          description="ID du rôle",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="nom", type="string"),
     *              @OA\Property(property="description", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Rôle mis à jour avec succès"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Rôle non trouvé",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="/api/roles/{role}",
     *      operationId="deleteRole",
     *      tags={"Roles"},
     *      summary="Supprimer un rôle",
     *      description="Supprime un rôle en fonction de l'ID fourni.",
     *      @OA\Parameter(
     *          name="role",
     *          description="ID du rôle",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Rôle supprimé avec succès",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Rôle non trouvé",
     *      ),
     *      security={
     *          {"api_key": {}}
     *      }
     * )
     */
    public function destroy(Role $role)
    {
        //
    }
}
