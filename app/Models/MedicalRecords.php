<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecords extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'diagnosis',
        'symptoms',
        'findings',
        'treatment',
        'vet_id',
        'appointment_id',
    ];


}
