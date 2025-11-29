<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'email' => 'charlesakwoyo@gmail.com',
                'password' => 'charles254',
                'first_name' => 'Charles',
                'last_name' => 'Akwoyo',
            ],
            [
                'email' => 'admin@example.com',
                'password' => 'password',
                'first_name' => 'Admin',
                'last_name' => 'User',
            ]
        ];

        foreach ($admins as $adminData) {
            if (!User::where('email', $adminData['email'])->exists()) {
                User::create([
                    'first_name' => $adminData['first_name'],
                    'last_name' => $adminData['last_name'],
                    'email' => $adminData['email'],
                    'password' => Hash::make($adminData['password']),
                    'email_verified_at' => now(),
                    'role' => 'admin',
                ]);

                $this->command->info('Admin user created successfully!');
                $this->command->info('Name: ' . $adminData['first_name'] . ' ' . $adminData['last_name']);
                $this->command->info('Email: ' . $adminData['email']);
                $this->command->info('Password: ' . $adminData['password']);
                $this->command->info('------------------------------');
            } else {
                $this->command->info('Admin user ' . $adminData['email'] . ' already exists. Skipping creation.');
            }
        }
    }
}