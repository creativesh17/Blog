<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // php artisan make:seed UsersTableSeeder
    public function run() {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Admin Khan',
            'username' => 'admin',
            'email' => 'admin@voila.com',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Author Khan',
            'username' => 'author',
            'email' => 'author@voila.com',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
        ]);
    }
}
