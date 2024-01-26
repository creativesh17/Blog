<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // php artisan make:seed UserRoleTableSeeder
    public function run() {
        DB::table('user_roles')->insert([
            'role_name' => 'Admin',
            'role_slug' => 'admin',
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Author',
            'role_slug' => 'author',
        ]);
    }
}
