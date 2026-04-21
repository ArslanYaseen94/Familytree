<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Types extends Model
{

    protected $table = 'tbl_types';

    protected $fillable = [
        'name',
        'is_active',
    ];
}
