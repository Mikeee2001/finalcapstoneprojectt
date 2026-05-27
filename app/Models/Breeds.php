<?php

namespace App\Models;

use App\Models\Pets;
use App\Models\Species;
use Illuminate\Database\Eloquent\Model;

class Breeds extends Model
{
    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function pets()
    {
        return $this->hasMany(Pets::class);
    }
}
