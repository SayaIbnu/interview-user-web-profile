<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class user_roles extends Model
{
    //
    use Uuid;
    
    public $incrementing = false;
    protected $keyType = 'string';
}
