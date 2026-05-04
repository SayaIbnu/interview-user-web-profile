<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Doctors extends Model
{
    use Uuid;

    public $incrementing = false;
    protected $keytype = "string";

    protected $fillable = [
        'name',
        'specialist',
        'photo',
        'description',
        'is_active'
    ];

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
