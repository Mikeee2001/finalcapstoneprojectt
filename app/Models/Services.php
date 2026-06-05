<?php

namespace App\Models;

use App\Models\Appointments;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
 protected $table = 'services';

    protected $fillable = [
        'service_name',
        'service_description',
        'price',
        'invoice_item_id',
        'status',
    ];


    public function appointments()
    {
        return $this->hasMany(Appointments::class, 'service_id');
    }


}
