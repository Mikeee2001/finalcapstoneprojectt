<?php

namespace App\Models;

use App\Models\Breeds;
use App\Models\Species;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pets extends Model
{
    protected $table = 'pets';

    protected $fillable = [
        'pet_name',
        'age',
        'gender',
        'species_id',
        'breed_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breeds::class);
    }
}
