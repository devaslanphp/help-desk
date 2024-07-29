<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FontAwesomeFreeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TicketDetailsSeeder::class);
        $this->call(TicketSeeder::class);
        $this->call(PermissionsSeeder::class);
    }
}
