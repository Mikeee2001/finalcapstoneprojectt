<?php

namespace App\Models;

use App\Models\Vet;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $table = 'specialization';
    protected $fillable = [
        'specialization_name',
    ];
    public function vets()
    {
        return $this->belongsToMany(
            Vet::class,
            'specialization_vet',
            'specialization_id',
            'veterinarian_id'
        );
    }
}
