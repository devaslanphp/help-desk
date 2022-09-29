# Getting started

To get and start developing into this application, please make sure to follow these steps:

## Prerequisites

The application is developed using Docker to make it simple to you to quick start development.
So before executing the application make sure you installed docker (https://www.docker.com/).


## Installation

Follow the below steps to install and serve the application into your development environment:

### Clone the project

Clone the project into your development environment:

```bash
git clone https://github.com/devaslanphp/help-desk.git
```

### Install dependencies

First thing after you cloned the project, is to install dependencies for each back and front:

- Back dependencies

```bash
composer install
```

- Front dependencies

```bash
npm install
```

### Docker initialization

Install docker images by executing:

```bash
./vendor/sail/bin up -d
```

If you want to use another way to configure this Laravel project please refer to [Laravel documentation](https://laravel.com/docs).

### Database configuration

Using the docker terminal for *laravel.test-1* container run the following command, to execute database migrations:

```bash
php artisan migrate
```

Using the docker terminal for *laravel.test-1* container run the following command, to execute database seeders:

```bash
php artisan db:seed
```

**Optional:** if you want to import demo data, follow the below steps:
1. Visit the docker image of **PHPMyAdmin** `http://127.0.0.1:8000`
2. Use the database `help_desk`
3. Import the SQL script file located in `{APP_ROOT}/database/help_desk.sql`

> If you used the demo data, you can use the following user accounts to access the application:
> 
> **Administrator**
> - Email address: darkvador@gmail.com
> - Password: Passw@rd
>
> **Customer**
> - Email address: janedoe@gmail.com
> - Password: Passw@rd
>
> **Employee**
> - Email address: johndoe@gmail.com
> - Password: Passw@rd

### Project structure

- `app/Http` - Contains all the business logic of the application
  - `app/Http/Controllers` - Controllers files
  - `app/Http/Livewire` - Livewire components (99% of business logic is here)
  - `app/Http/Middleware` - Middlewares used on different routes
- `app/View` - Blade components (used mainly for layouts and blade structure)
- `app/Jobs` - Jobs used to execute some complex functions
- `app/Notifications` - Notifications sent by email to application users
- `config` - Contains all the application configuration files
  - `config/system.php` - Application configuration file, that you can customize as you like (please read the comments in it to know how to customize values)
- `resources` - Contains all the application assets and views
  - `resources/css` - The stylesheet assets files
  - `resources/js` - The javascript assets files
  - `resources/views` - All the blade views for pages, blade components and livewire components
- `routes` - Contains all the routes used by the application
  - `routes/web.php` - the web routes (the only one used by the application)

### Theme customization

We have added SASS `.scss` files in template (see the **Project Structure** section). If you know how to use SASS you can change sass files and compile the css as well by executing the command `npm run build`.
