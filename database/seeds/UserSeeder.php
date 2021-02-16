<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'id' => 1,
          'role' => User::ROLES['ADMIN'],
          'status' => 1,
          'name' => 'admin',
          'email' => 'admin@admin.com',
          'phone' => '81262845980',
          'organisation' => '',
          'password' => '$2y$12$oQ63NRQaAV.L/ugDTealLeXXZR8d8ZM1R21h2/0fMo2zhqcNm72Yy', // admin
        ]);

        DB::table('users')->insert([
          'id' => 2,
          'role' => User::ROLES['USER'],
          'status' => 1,
          'name' => 'user',
          'email' => 'user@user.com',
          'phone' => '81262845980',
          'organisation' => '',
          'password' => '$2y$12$oQ63NRQaAV.L/ugDTealLeXXZR8d8ZM1R21h2/0fMo2zhqcNm72Yy', // admin
        ]);
    }
}
