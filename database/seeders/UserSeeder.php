<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mohammed Helmy',
            'email' => 'mohammedhelmy@example.com',
            'password' => bcrypt('123456789'),
            'phone' => '+201016440812',
            'address' => 'Assiut',
            'is_admin' => true,
        ]);

    }
}
