<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{

    protected $table = 'tbl_news';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'published_at'
    ];
}
