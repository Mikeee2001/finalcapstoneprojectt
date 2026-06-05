<?php

namespace App\Models;

use App\Models\MedicalRecords;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    protected $table = 'lab_test';

    protected $fillable = [
        'test_name',
        'description',
        'results',
        'notes',
        'records_id',
        'medicine_id'
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
