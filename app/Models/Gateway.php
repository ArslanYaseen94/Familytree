<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table = 'tbl_gateway';

    protected $fillable = [
        'cod_status',
        'digital_status',
        'paypal_status',
        'paypal_client_id',
        'paypal_secret',
        'stripe_status',
        'stripe_publish_key',
        'stripe_api_key',
    ];
}
