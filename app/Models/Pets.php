<?php

namespace App\Models;

use App\Models\Appointments;
use App\Models\Breeds;
use App\Models\MedicalRecords;
use App\Models\Species;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $table = 'pets';

    protected $fillable = [
        'pet_name',
        'age_type',
        'gender',
        'breed_id',
        'user_id',
        'age',
        'species_id',
        'pet_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breeds::class, 'breed_id');
    }

    public function species()
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointments::class, 'pet_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(
            MedicalRecords::class,
            'pet_id',
            'id'
        );
    }
}
