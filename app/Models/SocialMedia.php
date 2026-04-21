<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialMedia extends Model
{
    protected $table = 'tbl_socialmedia';
    protected $fillable =
    [
        "facebook",
        "twitter",
        'linekdin',
        "instagram",
        "user_id",
    ];
}
