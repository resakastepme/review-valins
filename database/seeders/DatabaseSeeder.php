<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::insert([
            [
                'username' => 'Test Admin',
                'role' => 1, //1 is Admin , 0 is User
                'email' => 'admin@admin.com',
                'password' => md5('admin')
            ],
            [
                    'username' => 'Test User',
                    'role' => 0,
                    'email' => 'user@user.com',
                    'password' => md5('user')
            ]
        ]);
    }
}
