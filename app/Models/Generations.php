<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Generations extends Model
{

    protected $table = 'tbl_generations';

    protected $fillable = [
        'name',
        'is_active',
    ];
}
