<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    protected $table = 'consultation';

    protected $fillable = [
        'diagnosis',
        'symptoms',
        'findings',
        'treatment',
        'vet_id',
        'appointment_id',
    ];


}
