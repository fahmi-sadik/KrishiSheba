<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@krishisheba.com'],
            [
                'name' => 'সিস্টেম অ্যাডমিন',
                'nid' => '0000000000',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}
