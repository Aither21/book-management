<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者
        User::insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'company' => 'KITU',
            'is_admin' => 1
        ]);

        // 一般
        User::insert([
            'name' => 'general',
            'email' => 'general@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'company' => 'KITU',
            'is_admin' => 0
        ]);
    }
}
