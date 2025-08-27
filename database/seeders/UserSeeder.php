<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some specific users
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
            ],
            [
                'name' => 'John Trader',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
            ],
            [
                'name' => 'Jane Collector',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
            ],
        ];

        foreach ($users as $userData) {
            DB::table('users')->insertOrIgnore($userData);
        }

        // Create additional random users
        User::factory(10)->create();
    }
}
