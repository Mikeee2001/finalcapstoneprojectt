<?php

namespace App\Models;

use App\Models\MedicalRecords;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    protected $fillable = [
        'date_given',
        'notes',
        'records_id',
        'medicine_id',
        'next_due_date'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecords::class,'records_id'
        );
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
