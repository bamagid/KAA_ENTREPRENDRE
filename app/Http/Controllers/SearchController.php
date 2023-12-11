<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    /**
     * @OA\Get(
     *     path="/search",
     *     summary="Effectuer une recherche",
     *     tags={"Recherche"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         required=true,
     *         description="Terme de recherche",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Résultats de la recherche",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ressources", type="array", @OA\Items(ref="#/components/schemas/Ressource")),
     *             @OA\Property(property="secteurs", type="array", @OA\Items(ref="#/components/schemas/Secteur")),
     *             @OA\Property(property="evenements", type="array", @OA\Items(ref="#/components/schemas/Evenement")),
     *         ),
     *     ),
     * )
     */
    public function search(Request $request)
    {
        $searchTerm = $request->query('q');

        // Recherche des ressources par titre
        $ressources = DB::table('ressources')
            ->select('id', 'titre', 'description')
            ->where('is_deleted', false)
            ->where('titre', 'LIKE', "%$searchTerm%")
            ->get();

        // Recherche des secteurs par nom du secteur
        $secteurs = DB::table('secteurs')
            ->select('id', 'nomSecteur')
            ->where('is_deleted', false)
            ->where('nomSecteur', 'LIKE', "%$searchTerm%")
            ->get();

        // Recherche des événements par nom d'événement
        $evenements = DB::table('evenements')
            ->select('id', 'nomEvenement', 'type', 'dateEvenement', 'lieuEvenement', 'description', 'image')
            ->where('is_deleted', false)
            ->where('nomEvenement', 'LIKE', "%$searchTerm%")
            ->get();

        return response()->json([
            'ressources' => $ressources,
            'secteurs' => $secteurs,
            'evenements' => $evenements,
        ]);
    }
}
