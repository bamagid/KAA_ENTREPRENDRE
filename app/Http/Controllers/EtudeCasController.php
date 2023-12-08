<?php

namespace App\Http\Controllers;

use App\Models\EtudeCas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class EtudeCasController extends Controller
{
    //utiliser cette fonction si vous voulez  lister les etudes de cas
    public function index()
    {
        $etudeCas=EtudeCas::all();
        return $etudeCas;
    }

//cette fonction cest pour ajouter des etudes de cas
        public function create_cas(Request $request)
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
            $etudeCas =new EtudeCas ($etudeCas);
           $etudeCas->contenu=$request->contenu;
           $etudeCas->image=$imagePath;
           $etudeCas->user_id=FacadesAuth::user()->id;
           $etudeCas->secteur_id=$request->secteur_id;
            $etudeCas->save();

            return response()->json(['message' => 'etudeCas ajouter avec succée', 'etudeCas' => $etudeCas], 200);

        }

//cete fonction cest pour modifier une etude de cas
    public function update(Request $request)
    {

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->contenu=$request->contenu;
        $etudeCas->image=$imagePath;
        $etudeCas->user_id=FacadesAuth::user()->id;
        $etudeCas->secteur_id=$request->secteur_id;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas modifer avec succée', 'etudecas' => $etudeCas], 200);
    }

   //cette fonction cest pour archiver une etude de cas
    public function archive(Request $request){

        $etudeCas = EtudeCas::find($request->id);

        $etudeCas->is_deleted=true;
        $etudeCas->save();

        return response()->json(['message' => 'etude cas archiver avec succée', 'etudecas' => $etudeCas], 200);
    }

//si vous voulez supprimer une etude de cas utiliser cette fonction
    public function delete(Request $request)
    {
        $etudeCas = EtudeCas::find($request->id);
        $etudeCas->delete();

        return response()->json(['message' => 'etude cas supprimer avec succée', 'etudecas' => $etudeCas], 200);
    }
}
