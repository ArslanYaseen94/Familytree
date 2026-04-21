<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_members';
    
    protected $fillable = [
        'family_id',
        'firstname',
        'lastname',
        'type',
        'gender',
        'death',
        'village',
        'birthdate',
        'marriagedate',
        'deathdate',
        'user',
        'photo',
        'avatar',
        'facebook',
        'twitter',
        'instagram',
        'email',
        'tel',
        'mobile',
        'site',
        'birthplace',
        'deathplace',
        'profession',
        'company',
        'interests',
        'bio',
        'images'
    ];
    
    // Define relationships based on 'type'
    public function children()
    {
        return $this->hasMany(Member::class, 'parent_id')->where('type', 1);
    }

    public function partners()
    {
        return $this->hasMany(Member::class, 'parent_id')->where('type', 2);
    }

    public function exPartners()
    {
        return $this->hasMany(Member::class, 'parent_id')->where('type', 3);
    }

    public function parent()
    {
        return $this->belongsTo(Member::class, 'parent_id')->where('type', 4);
    }
        public function family()
    {
        return $this->belongsTo(FamilyTree::class, 'family_id');
    }
}
