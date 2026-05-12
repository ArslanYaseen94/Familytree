<?php
namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $members;

    public function __construct($members)
    {
        $this->members = $members;
    }

    public function collection()
    {
        return $this->members;
    }

    public function headings(): array
    {
        return ['ID', 'Family ID', 'Parent ID', 'First Name', 'Last Name', 'Type', 'Gender', 'Death', 'Birthdate', 'Marriage Date', 'Deathdate', 'User', 'Photo', 'Avatar', 'Facebook', 'Twitter', 'Instagram', 'Email', 'Tel', 'Mobile', 'Site', 'Birthplace', 'Deathplace', 'Profession', 'Company', 'Interests', 'Bio', 'Images', 'Created At'];
    }

    public function map($member): array
    {
        return [$member->id, $member->family_id, $member->parent_id, $member->firstname, $member->lastname, $member->type, $member->gender, $member->death, $member->birthdate, $member->marriagedate, $member->deathdate, $member->user, $member->photo, $member->avatar, $member->facebook, $member->twitter, $member->instagram, $member->email, $member->tel, $member->mobile, $member->site, $member->birthplace, $member->deathplace, $member->profession, $member->company, $member->interests, $member->bio, $member->images, $member->created_at];
    }
}
