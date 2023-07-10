<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Rizal',
            'email' => 'rizal@mail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Bintang',
            'email' => 'bintang@mail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Fahri',
            'email' => 'fahri@mail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Fara',
            'email' => 'fara@mail.com',
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => 'Farra',
            'email' => 'farra@mail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
