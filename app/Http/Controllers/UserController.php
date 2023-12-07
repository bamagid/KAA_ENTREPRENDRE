<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function ajouterRole(Request $request)
    {
        $request->validate([
            'nomRole' => 'required|string|unique:roles',
        ]);

        $role = Role::create([
            'nomRole' => $request->nomRole,
        ]);

        return response()->json(['message' => 'Rôle ajouté avec succès'], 201);
    }


    public function ajouterUtilisateurEntrepreneurNovice(Request $request)
    {
       
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
        $roleEntrepreneurNovice = Role::where('nomRole', 'entrepreneur_novice')->first();

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'region'=> $request->region,
            'role_id' => $roleEntrepreneurNovice->id, // Obtenir l'ID du rôle
            'statut' => $request->statut,
            'image'=> $imagePath
        ]);
    
        $user->roles()->attach($roleEntrepreneurNovice);
    
        return response()->json(['message' => 'Utilisateur ajouté avec succès'], 201);
    }



    public function ajouterUtilisateurEntrepreneurExperimente(Request $request)
    {
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
    
        $roleEntrepreneurExperimente = Role::where('nomRole', 'entrepreneur_experimente')->first();
    
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'region' => $request->region,
            'role_id' => $roleEntrepreneurExperimente->id,
            'statut' => $request->statut,
            'image' => $imagePath,
            'experience'=>$request->experience,
            'activite' =>$request->activite,
            'realisation'=>$request->realisation
        ]);
    
        $user->roles()->attach($roleEntrepreneurExperimente);
    
        return response()->json(['message' => 'Entrepreneur expérimenté ajouté avec succès'], 201);
    }



    public function ajouterUtilisateurAdmin(Request $request)
    {
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
    
        $roleAdmin = Role::where('nomRole', 'admin')->first();
    
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'region' => $request->region,
            'role_id' => $roleAdmin->id,
            'statut' => $request->statut,
            'image' => $imagePath
        ]);
    
        $user->roles()->attach($roleAdmin);
    
        return response()->json(['message' => 'Admin ajouté avec succès'], 201);
    }
    public function login(Request $request){
        
        // data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if(!empty($token)){

            return response()->json([
                "status" => true,
                "message" => "utilisateur connecter avec succe",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "details invalide"
        ]);
    }

}
