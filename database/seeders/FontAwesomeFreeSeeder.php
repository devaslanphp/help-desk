<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FontAwesomeFreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = __DIR__ . '/scripts/fontawesome.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
