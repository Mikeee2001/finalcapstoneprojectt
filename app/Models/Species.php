<?php

namespace App\Models;

use App\Models\Breeds;
use App\Models\Pets;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $table = 'species';

    protected $fillable = [
        'species_name',
    ];

    public function breeds()
    {
        return $this->hasMany(Breeds::class);
    }

    public function pets()
    {
        return $this->hasMany(Pets::class);
    }
}
