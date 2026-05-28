<?php

namespace App\Models;

use App\Models\Species;
use Illuminate\Database\Eloquent\Model;

class Breeds extends Model
{
    protected $table = 'breeds';

    protected $fillable = [
        'breed_name',
        'species_id',
    ];
    public function species()
    {
        return $this->belongsTo(Species::class);
    }


}
