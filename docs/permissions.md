# Permissions

> The package used to manage the permissions is `spatie/laravel-permission` (you can check the [official docs here](https://spatie.be/docs/laravel-permission/)).

The Help Desk application uses the Roles / Permissions to manage the users permissions to access pages and functions.

## Seeder

By default, there is a set of pre-configured permissions that you can insert into your database by running the seeder `php artisan db:seed --class=PermissionsSeeder` (you can refer to the [Database configuration](/getting-started?id=database-configuration) of the Getting started section for more information).

So if you want to add / update permissions managed by the application, you need to update the `Database\Seeders\PermissionsSeeder` seeder and more precisely the variable `const permissions`.

> **Important:** The seeder check if the permission to insert already exists before inserting it into the database, so you can execute the seeder multiple time if you want.

