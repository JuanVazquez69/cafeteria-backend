<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = true;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'perfil_id',
        'name',
        'email',
        'password',
        'baja'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function contactos(){
        return $this->hasMany(Contactos::class, 'user_id', 'user_id');
    }

    public function plantillaSeccionUsuarios(){
        return $this->hasMany(PlantillaSeccionUsuarios::class, 'user_id', 'user_id');
    }

    public function perfil(){
        return $this->belongsTo(Perfil::class, 'perfil_id', 'perfil_id');
    }
}
