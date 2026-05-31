<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Services;

class Categories extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'category_name',
    ];

    public function services()
    {
        return $this->hasMany(Services::class, 'category_id');
    }
}
