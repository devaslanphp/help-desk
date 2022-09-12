## Installation

1. Unzip the project archive file
2. Access to the folder root with your terminal
3. Install Back-end dependencies `composer install`
4. Install Front-end dependencies `npm install`
5. Build assets `npm run build`
6. Configure `.env` file (refer to [Laravel docs](https://laravel.com/docs) for more information about configure environment file)
7. Import the demo database located at `{ROOT_PROJECT}/database/help_desk.sql`
8. Or, you can run migrations by executing `php artisan migrate` and create your own `User` (it must have the `administrator` role)
