<?php

namespace App\Models;

use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $table = 'prescription_items';
    protected $fillable = [
        'dosage',
        'frequency',
        'days',
        'instructions',
        'quantity',
        'prescription_id',
        'medicine_id'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
