# KrishiSheba

KrishiSheba is a Bangla-language agriculture marketplace and admin platform. This repository contains both the legacy PHP front-end and admin pages as well as a parallel Laravel application scaffold under `laravel_app/`.

## Repository structure

- `admin/` - legacy admin dashboard and settings pages
- `auth/` - legacy login and registration pages
- `buyer/` - legacy buyer dashboard, cart, and settings pages
- `assets/` - shared CSS and image assets for legacy UI
- `laravel_app/` - Laravel application scaffold with controllers, models, migrations, routes, and views
- `db.sql` - SQL dump for the legacy application database schema and sample data

## Branch focus

The current branch `feature/legacy-integration` is focused on:

- preserving legacy PHP admin/buyer functionality
- migrating and integrating legacy assets and UI pages
- introducing a new Laravel application structure for future development
- making incremental frontend improvements such as admin settings persistence

## Legacy PHP usage

To run the legacy PHP UI, use a PHP-capable web server and point it to the repository root.

1. Install PHP if needed.
2. Start a local PHP server from the repository root:

```bash
php -S localhost:8000
```

3. Open `http://localhost:8000/index.php` in a browser.

## Laravel application usage

The `laravel_app/` directory contains a Laravel project.

1. Change into the Laravel directory:

```bash
cd laravel_app
```

2. Install dependencies:

```bash
composer install
npm install
```

3. Copy the environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Run database migrations:

```bash
php artisan migrate
```

5. Start the development server and frontend build:

```bash
php artisan serve
npm run dev
```

## Notes

- The Laravel app is structured for future modernization and contains drivers for authentication, product management, orders, and admin functionality.
- The legacy PHP portion continues to use static pages and local storage-based UI enhancements for admin features.
- The repository currently does not include a dedicated root-level production deployment configuration.

## Contribution

If you want to contribute, please open a branch from `main` or `feature/legacy-integration` and submit a pull request with a clear summary of your changes.
