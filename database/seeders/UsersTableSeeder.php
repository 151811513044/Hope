<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin 1',
            'role' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(60),
            'email_verified_at' => new \DateTime
        ]);
        User::create([
            'name' => 'Admin 2',
            'role' => 'admin',
            'email' => 'admin2@app.com',
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(60),
            'email_verified_at' => new \DateTime
        ]);
    }
}
