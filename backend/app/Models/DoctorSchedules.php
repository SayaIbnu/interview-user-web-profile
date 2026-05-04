<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class DoctorSchedules extends Model
{
    //
    use Uuid;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'doctor_id',
        'day',
        'start_time',
        'end_time',
        'room'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }
}
