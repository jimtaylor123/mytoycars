<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Create user for development log in
         factory(User::class)->create([
            'name' => 'Test User',
            'email' => 'test@user.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$U1i8XMlwIO1XaqnINGwYv.5T9eVK/FP6djmicpF63aYP3U5I7vLY2', // 12345678
            'remember_token' => Str::random(10),
        ]);

        // Create other example users, all with the same example password
        factory(User::class, 50)->create(['password' => 'Password123']);
    }
}
