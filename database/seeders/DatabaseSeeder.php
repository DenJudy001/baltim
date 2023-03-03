<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(4)->create();
        User::create([
           'name' => "RM Baltim",
           'username' => "baltim",
           'email' => "baltim@gmail.com",
           'password' => bcrypt('12345')
        ]);
    }
}
