<?php

namespace App\Models;

use App\Models\Pets;
use App\Models\Services;
use App\Models\Vet;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'requested_date',
        'requested_time',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'pet_id',
        'service_id',
        'vet_id',
    ];

    public function pets()
    {
        return $this->belongsTo(Pets::class, 'pet_id');
    }

    public function vets()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }


}
