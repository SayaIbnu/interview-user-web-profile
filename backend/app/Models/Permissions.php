<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Permissions extends Model
{
    use Uuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(
            Roles::class,
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }
}
