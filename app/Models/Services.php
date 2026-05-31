<?php

namespace App\Models;

use App\Models\Appointments;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
 protected $table = 'services';

    protected $fillable = [
        'service_name',
        'description',
        'price',
        'invoice_item_id',
        'category_id',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointments::class, 'service_id');
    }


}
