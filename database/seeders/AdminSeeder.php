<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email = env('SEED_ADMIN_EMAIL', 'admin2@example.com');
        $password = env('SEED_ADMIN_PASSWORD', 'Admin@123456');
        $name = env('SEED_ADMIN_NAME', 'Admin 2');

        $exists = DB::table('tbl_admin')->where('email', $email)->exists();
        if ($exists) {
            return;
        }

        DB::table('tbl_admin')->insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'Status' => 0,
            'language' => 'english',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

