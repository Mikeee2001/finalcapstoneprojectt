<?php

namespace App\Models;

use App\Models\Services;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable =
    [
        'category_name',
    ];

    public function services()
    {
        return $this->hasMany(Services::class);
    }

}
