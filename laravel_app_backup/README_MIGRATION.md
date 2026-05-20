# KrishiSheba Laravel Migration (Foundation)

This folder contains the Laravel-structured migration foundation with these implemented modules:

- Role-based authentication (`farmer`, `buyer`, `expert`, `admin`)
- Expert registration with document upload
- Admin approval required for expert login
- Admin dashboard for pending expert verification + ad publishing
- Farmer issue submission
- Expert dashboard for issue solving, guide/article upload
- Farmer-expert chat module
- Ad banner component shown across user-facing pages
- Payout ledger entry per answered issue

## Important setup steps on your machine

1. Initialize Laravel dependencies:
   - `cd laravel_app`
   - `composer install`
2. Configure `.env` database credentials for `krishisheba`.
3. Register `RoleMiddleware` alias in your Laravel middleware config.
4. Run migrations:
   - `php artisan migrate`
5. Create storage symlink for expert documents:
   - `php artisan storage:link`

## Data migration from old `db.sql`

The new migration file `database/migrations/2026_05_13_000000_create_core_tables.php` recreates and extends the schema for expert approval, ads, chat, and payouts.
