<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


     public function getJWTIdentifier()
     {
       return $this->getKey();
     }
 
     public function getJWTCustomClaims()
     {
       return [];
     }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function guides(){
        return $this->hasMany(Guide::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function evenements(){
        return $this->hasMany(Evenement::class);
    }
    public function ressources(){
        return $this->hasMany(Ressource::class);
    }
    public function forums(){
        return $this->hasMany(Forum::class);
    }
    public function secteurs(){
        return $this->hasMany(Secteur::class);
    }
    public function commentaires(){
        return $this->hasMany(Commentaire::class);
    }
    public function reponses(){
        return $this->hasMany(Reponse::class);
    }
    public function etudeCas(){
        return $this->hasMany(EtudeCas::class);
    }
    public function hasRole($role)
    {
        return $this->roles->contains('nomRole', $role);
    }
}
