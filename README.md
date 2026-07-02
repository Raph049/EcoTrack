# EcoTrack

EcoTrack is a Laravel-based waste management web application for reporting, tracking, and managing waste collection requests. The project includes user authentication, role-based access for normal users and admin roles, and admin tools for assignments and reporting.

## Project purpose

EcoTrack helps communities and waste authorities:

- submit waste collection requests
- track request status
- assign requests to collectors
- view analytics and system settings for administrators

## Tech stack

- Laravel 12
- PHP 8.2+
- Breeze authentication scaffolding
- Spatie Laravel Permission
- SQLite by default for local development
- Vite + Tailwind CSS

## Requirements

Before running the project, make sure you have:

- PHP 8.2 or newer
- Composer
- Node.js and npm

## Local setup

From the project root:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run dev
```

If you are using the default SQLite setup, make sure the database file exists:

```bash
touch database/database.sqlite
```

Then start the app:

```bash
php artisan serve
```

Open the app at:

```text
http://127.0.0.1:8000
```

## Default login

A seeded demo account is available after running the seeders:

- Email: test@example.com
- Password: password

## Main application areas

- Authentication and account management: [routes/auth.php](routes/auth.php)
- Main application routes: [routes/web.php](routes/web.php)
- Front-end views: [resources/views](resources/views)
- Models and business logic: [app](app)
- Database migrations and seeders: [database](database)

## Useful commands

```bash
php artisan migrate:fresh --seed
php artisan test
npm run build
```

## Notes

The app uses role-based access control. Users with the role `normal end user` can submit and view requests, while admin roles can access authority and admin sections.
