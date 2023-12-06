<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\JwtId;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\Auth;


class UserController extends Controller
{

    // public function create(Request $request){
    //     $user = new User();
    //     $user->nom = $request->nom;
    //     $user->prenom = $request->prenom;
    //     $user->email = $request->email;
    //     $user->password = $request->password;
    //     $user->adresse = $request->adresse;
    //     $user->region = $request->region;
    //     $user->statut = $request->statut;
    //     $user->image = $request->image;


    //     if ($request->statut == 'experimente') {
    //         $user->experience= $request->experience;
    //         $user->realisation= $request->realisation;
    //         $user->activite= $request->activite;
    //         $user->role_id=2;

    //     } elseif ($request->statut == 'novice') {
    //         $user->progression = $request->progression;
    //         $user->role_id=3;
    //     }

    //     if ($user->save()) {

    //     }
    // }

    public function register(Request $request){

        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"

        ]);

        // User Model
        User::create([
            "nom" => $request->nome,
            "prenom" => $request->prenom,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "adresse" => $request->adresse,
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
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
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
    }
}
