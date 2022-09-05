<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::create(['name' => 'Main']);
        Tenant::create(['name' => 'Event']);
        Tenant::create(['name' => 'Course']);
        Tenant::create(['name' => 'Book']);
        Tenant::create(['name' => 'Traineeship']);
    }
}
