<?php

namespace App\Models;

use App\Models\Breeds;
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

}
