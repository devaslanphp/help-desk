<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Seeders\DateTime;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            array(
                'name' => 'administrator',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Head of Department',
                'email' => 'hod@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'technician',
                'email' => 'tech@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'technician 2',
                'email' => 'tech2@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Asraf',
                'email' => 'asraf.educ.it@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Syariff Ghani',
                'email' => 'syariffghani@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Nurul Khaliesah',
                'email' => 'khaliesah@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Haikal Handali',
                'email' => 'haikal@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('users')->insert(
            array(
                'name' => 'Hazmie Khalid',
                'email' => 'hazmie@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );
    }
}
