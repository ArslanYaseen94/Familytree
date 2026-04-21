<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'tbl_messages';
    protected $fillable =

    [
        'sender_id',
        "recipient_id",
        "subject",
        "body"
    ];
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
    public function replies()
    {
        return $this->hasMany(Messages::class, 'parent_id')->orderBy('created_at');
    }
}
