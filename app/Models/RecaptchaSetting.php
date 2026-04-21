<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecaptchaSetting extends Model
{
    protected $table = 'tbl_recaptcha';

    protected $fillable = [
        'status',
        'site_key',
        'secret_key',
    ];
}