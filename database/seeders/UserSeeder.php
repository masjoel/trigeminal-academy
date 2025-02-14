<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::truncate();
        User::create(
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ]
        );
        User::create(
            [
                'name' => 'Guest',
                'username' => 'guest',
                'email' => 'guest@guest.com',
                'password' => Hash::make('guest12345'),
                'role' => 'user',
            ]
        );
        User::create(
            [
                'name' => 'Staf',
                'username' => 'staf',
                'email' => 'staf@staf.com',
                'password' => Hash::make('staf12345'),
                'role' => 'staf',
            ]
        );
        User::create(
            [
                'name' => 'Operator',
                'username' => 'operator',
                'email' => 'operator@operator.com',
                'password' => Hash::make('operator12345'),
                'role' => 'operator',
            ]
        );
    }
}
