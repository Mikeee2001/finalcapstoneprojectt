<?php

namespace App\Models;

use App\Models\Appointments;
use App\Models\LabTest;
use App\Models\Pets;
use App\Models\Prescription;
use App\Models\Vaccination;
use App\Models\Vet;
use Illuminate\Database\Eloquent\Model;

class MedicalRecords extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'diagnosis',
        'symptoms',
        'findings',
        'treatment',
        'appointment_id',
        'pet_id',
        'vet_id'
    ];

    public function pets()
    {
        return $this->belongsTo(
            Pets::class,
            'pet_id',
            'id'
        );
    }

    public function appointment()
    {
        return $this->belongsTo(Appointments::class);
    }

    public function vet()
    {
        return $this->belongsTo(Vet::class, 'vet_id');
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class, 'records_id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class, 'records_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'medical_records_id');
    }
}
