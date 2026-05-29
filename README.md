# doctor-anand-website

Laravel + Inertia + React website for Dr. Anand (copied from the mumbai-home-visit codebase).

## Setup

1. Copy environment file: `cp .env.example .env` and configure database and app settings.
2. Install PHP dependencies: `composer install`
3. Install Node dependencies: `npm install`
4. Generate app key: `php artisan key:generate`
5. Run migrations: `php artisan migrate`
6. Build assets: `npm run build`

See the original project documentation in this repo for PHP version, Filament admin, and production deployment notes.
