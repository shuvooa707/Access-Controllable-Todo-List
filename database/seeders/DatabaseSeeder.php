<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        User::create([
            'name' => "shuvo",
            'email' => "shuvo@gmail.com",
            'username' => "shuvo",
            'email_verified_at' => now(),
            'password' => Hash::make("shuvo"),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => "simba",
            'email' => "simba@jungleking.com",
            'username' => "simba",
            'email_verified_at' => now(),
            'password' => Hash::make("simba"),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => "tarzen",
            'email' => "tarzen@jungleking.com",
            'username' => "tarzen",
            'email_verified_at' => now(),
            'password' => Hash::make("tarzen"),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => "tom",
            'email' => "tom@jungleking.com",
            'username' => "tom",
            'email_verified_at' => now(),
            'password' => Hash::make("tom"),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => "jack",
            'email' => "jack@jungleking.com",
            'username' => "jack",
            'email_verified_at' => now(),
            'password' => Hash::make("jack"),
            'remember_token' => Str::random(10),
        ]);
    }
}
