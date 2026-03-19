<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Administrator',
                'username'  => 'admin',
                'email'     => 'admin@pegadaian.local',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'is_active' => true,
            ],
            [
                'name'      => 'Kasir Utama',
                'username'  => 'kasir',
                'email'     => 'kasir@pegadaian.local',
                'password'  => Hash::make('password'),
                'role'      => 'kasir',
                'is_active' => true,
            ],
            [
                'name'      => 'Viewer',
                'username'  => 'viewer',
                'email'     => 'viewer@pegadaian.local',
                'password'  => Hash::make('password'),
                'role'      => 'viewer',
                'is_active' => true,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(['username' => $data['username']], $data);
        }
    }
}
