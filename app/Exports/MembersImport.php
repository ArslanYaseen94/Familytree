<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Member([
            'id'            => $row['id'],
            'family_id'     => $row['family_id'],
            'parent_id'     => $row['parent_id'],
            'firstname'     => $row['first_name'],
            'lastname'      => $row['last_name'],
            'type'          => $row['type'],
            'gender'        => $row['gender'],
            'death'         => $row['death'],
            'birthdate'     => $row['birthdate'],
            'marriage_date' => $row['marriage_date'],
            'deathdate'     => $row['deathdate'],
            'user'          => $row['user'],
            'photo'         => $row['photo'],
            'avatar'        => $row['avatar'],
            'facebook'      => $row['facebook'],
            'twitter'       => $row['twitter'],
            'instagram'     => $row['instagram'],
            'email'         => $row['email'],
            'tel'           => $row['tel'],
            'mobile'        => $row['mobile'],
            'site'          => $row['site'],
            'birthplace'    => $row['birthplace'],
            'deathplace'    => $row['deathplace'],
            'profession'    => $row['profession'],
            'company'       => $row['company'],
            'interests'     => $row['interests'],
            'bio'           => $row['bio'],
            'images'        => $row['images'],
            'created_at'    => $row['created_at'],
        ]);
    }
}
