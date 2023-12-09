<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\MotDePasseOublié;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        return response()->json(['message' => 'Rôle ajouté avec succès','role'=>$role], 201);
    }


    public function ajouterUtilisateurEntrepreneurNovice(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'adresse' => 'required|string|regex:/^[a-zA-Z0-9 ]+$/',
            'region' => 'required|string|regex:/^[a-zA-Z ]+$/',
            'statut' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }
        $roleEntrepreneurNovice = Role::where('nomRole', 'novice')->first();
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'region'=> $request->region,
            'role_id' => $roleEntrepreneurNovice->id,
            'statut' => $request->statut,
            'image' => $imagePath,
            'progression' => $request->progression
        ]);

        $user->roles()->attach($roleEntrepreneurNovice);

        return response()->json(['message' => 'Utilisateur ajouté avec succès'], 201);
    }



    public function ajouterUtilisateurEntrepreneurExperimente(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'adresse' => 'required|string|regex:/^[a-zA-Z0-9 ]+$/',
            'region' => 'required|string|regex:/^[a-zA-Z ]+$/',
            'statut' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
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
            'role_id' => $request->role_id,
            'statut' => $request->statut,
            'image' => $imagePath,
            'experience' => $request->experience,
            'activite' => $request->activite,
            'realisation' => $request->realisation
        ]);

        $user->roles()->attach($roleEntrepreneurExperimente);

        return response()->json(['message' => 'Entrepreneur expérimenté ajouté avec succès'], 201);
    }



    public function ajouterUtilisateurAdmin(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'prenom' => 'required|string|min:4|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',

            'statut' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajoutez des règles pour la validation de l'image si nécessaire
        ]);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
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
            'role_id' => $request->role_id,
            'statut' => $request->statut,
            'image' => $imagePath
        ]);

        $user->roles()->attach($roleAdmin);

        return response()->json(['message' => 'Admin ajouté avec succès'], 201);
    }
    public function login(Request $request)
    {

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

        if (!empty($token)) {

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
    public function deconnect()
    {
        //J'utilise la façade Auth pour faire la deconnexion
        Auth::logout();
        session()->invalidate();

        session()->regenerateToken();

        return redirect('/');
    }


    public function updateProfile(Request $request)
    {
        $entrepreneurNovice = auth()->user();

        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $entrepreneurNovice->id,
            'password' => 'nullable|min:6',
            'adresse' => 'required|string',
            'region' => 'required|string',
            'statut' => 'required|string',

        ]);

        $imagePath = $entrepreneurNovice->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

        $entrepreneurNovice->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $entrepreneurNovice->password,
            'adresse' => $request->adresse,
            'region' => $request->region,
            'statut' => $request->statut,
            'image' => $imagePath,

        ]);

        return response()->json(['message' => 'Profil mis à jour avec succès'], 200);
    }





    public function updateProfileExperimente(Request $request)
    {
        $entrepreneurExperimente = auth()->user();

    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $entrepreneurExperimente->id,
        'password' => 'nullable|min:6',
        'adresse' => 'required|string',
        'region' => 'required|string',
        'statut' => 'required|string',
        'experience' => 'required|string',
        'activite' => 'required|string',
        'realisation' => 'required|string',

    ]);

        $imagePath = $entrepreneurExperimente->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

    $entrepreneurExperimente->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'password' => $request->password ? Hash::make($request->password) : $entrepreneurExperimente->password,
        'adresse' => $request->adresse,
        'region' => $request->region,
        'statut' => $request->statut,
        'experience' => $request->experience,
        'activite' => $request->activite,
        'realisation' => $request->realisation,
        'image' => $imagePath,

    ]);

        return response()->json(['message' => 'Profil mis à jour avec succès'], 200);
    }

    public function UpdateAdmin(Request $request)
    {


        $admin = auth()->user();

    $request->validate([
        'nom' => 'required|string',
        'prenom' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $admin->id,
        'password' => 'nullable|min:6',
        'adresse' => 'required|string',
        'region' => 'required|string',
        'statut' => 'required|string',


    ]);

        $imagePath = $admin->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public');
        }

    $admin->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'password' => $request->password ? Hash::make($request->password) : $admin->password,
        'adresse' => $request->adresse,
        'region' => $request->region,


        'image' => $imagePath,

    ]);

        return response()->json(['message' => 'Profil mis à jour avec succès'], 200);
    }


    public function toggleBlockAccount($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->toggleStatus();

        $status = $user->statut === 'actif' ? 'débloqué' : 'bloqué';

        return response()->json(['message' => "Compte $status avec succès"], 200);
    }





public function modifierMotDePasse(Request $request)
    {
        $request->validate([
            'ancien_password' => 'required',
            'nouveau_password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ]);

        $user = Auth::user();

        // Vérifiez que l'ancien mot de passe est correct
        if (!Hash::check($request->ancien_password, $user->password)) {
            return response()->json(['message' => 'Mot de passe actuel incorrect'], 401);
        }

        // Mettez à jour le mot de passe avec le nouveau
        $user->password = Hash::make($request->nouveau_password);
        // $user->notify(new MotDePasseOublié());
        $user->save();

        return response()->json(['message' => 'Mot de passe modifié avec succès'], 200);
    }

    public function verifMail(Request $request){
        $user=User::where('email',$request->email)->first();
        if($user){
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur trouvé',
                'user' => $user,
            ]);
        }
    }

    public function resetPassword(Request $request,User $user){
        $user->password=$request->password;
        $user->save();
        if($user){
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Votre mot de passe a été modifier',
                'user' => $user,
            ]);
        }

    }

}
