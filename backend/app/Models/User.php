<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uuid;

class User extends Authenticatable implements JWTSubject
{
    use Uuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 🔥 WAJIB untuk JWT
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 🔥 WAJIB untuk JWT
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(
            Roles::class,
            'user_roles',
            'user_id',  // FK ke user
            'role_id'   // FK ke role
        );
    }

    public function permissions()
    {
        return $this->roles->flatMap->permissions;
    }

    public function hasPermission($permission)
    {
        return $this->roles()
            ->whereHas('permissions', function ($q) use ($permission) {
                $q->where('name', $permission);
            })
            ->exists();
    }
}
