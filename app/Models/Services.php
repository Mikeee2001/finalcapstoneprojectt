<?php

namespace App\Models;

use App\Models\Category;
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
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
