<?php

namespace App\Models;

use App\Models\Appointments;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Vet extends Model
{
    protected $table = 'veterinarian';

    protected $fillable = [
        'license_number',
        'hire_date',
        'status',
        'user_id',
        'specialization_vet',
        'specialization_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function specializations()
    {
        return $this->belongsToMany(
            Specialization::class,
            'specialization_vet',
            'veterinarian_id',
            'specialization_id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(Appointments::class, 'vet_id');
    }
}
