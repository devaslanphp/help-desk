<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    const permissions = [
        'View all projects',
        'Update all projects',
        'Delete all projects',
        'Create projects',
        'View own projects',
        'Update own projects',
        'Delete own projects',
        'View all tickets',
        'Update all tickets',
        'Delete all tickets',
        'Create tickets',
        'View own tickets',
        'Update own tickets',
        'Delete own tickets',
        'Assign tickets',
        'Change status tickets',
        'Can view Analytics page',
        'Can view Tickets page',
        'Can view Kanban page',
        'View all users',
        'View company users',
        'Create users',
        'Update users',
        'Delete users',
        'Assign permissions',
        'View all companies',
        'View own companies',
        'Create companies',
        'Update companies',
        'Delete companies',
        'Manage ticket statuses',
        'Manage ticket priorities',
        'Manage ticket types',
        'View activity log',
        'Manage user roles',
        'Create user roles',
        'Update user roles',
        'Delete user roles',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::permissions as $permission) {
            if (!Permission::where('name', $permission)->count()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
