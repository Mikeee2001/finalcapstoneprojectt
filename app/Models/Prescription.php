<?php

namespace App\Models;

use App\Models\MedicalRecords;
use App\Models\PrescriptionItem;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescription';
    protected $fillable = [
        'prescription_date',
        'notes',
        'recommendations',
        'medical_records_id'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecords::class,'medical_records_id'
        );
    }

    public function items()
    {
        return $this->hasMany(
            PrescriptionItem::class,
            'prescription_id'
        );
    }
}
