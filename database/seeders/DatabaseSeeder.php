<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\PartnerSeeder;
use Database\Seeders\CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PartnerSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(CategorySeeder::class);
        \App\Models\User::factory(10)->create();
        $this->call(EventSeeder::class);
    }
}
