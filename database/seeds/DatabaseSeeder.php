<?php

use Illuminate\Database\Seeder;
use Database\Seeders\ChemicalSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(ChemicalSeeder::class);
    }
}
