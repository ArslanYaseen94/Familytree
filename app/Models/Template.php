<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    protected $table = 'tbl_templates';


    protected $fillable = [
        'name',
        'image',
    ];
}
