# Production deployment guide

This application is **Laravel 13** with **Inertia + React**, **Filament** admin, and optional **JSON API**. Use this checklist on a Linux server (Ubuntu LTS is a common choice).

---

## 1. What to install on the server

### PHP **8.4** (required)

Install PHP-FPM (or `php-cli` only if you use Octane/RoadRunner) and extensions this stack typically needs:

| Package (Ubuntu-style names) | Why |
|------------------------------|-----|
| `php8.4-fpm` | Serves PHP behind Nginx/Apache |
| `php8.4-cli` | `artisan`, Composer, cron |
| `php8.4-mbstring` | Laravel, strings |
| `php8.4-xml` | XML, common deps |
| `php8.4-curl` | HTTP client |
| `php8.4-zip` | Composer, archives |
| `php8.4-intl` | Internationalization (often used) |
| `php8.4-bcmath` | Some libs / money |
| `php8.4-opcache` | **Strongly recommended** in production |

**Database driver (pick one):**

| If you use | Install (example) |
|------------|-------------------|
| **MySQL / MariaDB** | `php8.4-mysql` |
| **PostgreSQL** | `php8.4-pgsql` |
| **SQLite** (small sites only) | `php8.4-sqlite3` |

Verify:

```bash
php8.4 -v
php8.4 -m | grep -iE 'pdo|mysql|pgsql|sqlite|mbstring|curl|zip|opcache'
```

### Composer

Install [Composer 2](https://getcomposer.org/download/) globally. Run installs with the **same** PHP as FPM:

```bash
php8.4 "$(command -v composer)" install --no-dev --optimize-autoloader
```

### Node.js (build machine or CI only)

**Vite** builds front-end assets. You only need Node where you run `npm run build` (CI pipeline or a build server); the **production web server does not need Node** if you commit or upload built files under `public/build/`.

- **Node 18+** (see project `README.md`).

```bash
npm ci
npm run build
```

### Web server

- **Nginx** or **Apache** pointing document root to `public/` (not project root).
- **TLS**: use Let’s Encrypt (`certbot`) or your host’s managed SSL.

### Optional but common

| Tool | Use |
|------|-----|
| **Supervisor** | Keep `php artisan queue:work` running if `QUEUE_CONNECTION` is not `sync` |
| **Redis** | Cache, sessions, queues (`CACHE_STORE=redis`, etc.) at scale |
| **Cron** | Laravel scheduler: `* * * * * php /path/to/artisan schedule:run` |

---

## 2. Database setup

### Recommendation

- **MySQL 8+** or **MariaDB 10.6+** or **PostgreSQL 15+** for production.
- **SQLite** is acceptable only for very low traffic or demos; avoid NFS-mounted SQLite.

### MySQL / MariaDB example

1. Create database and user (adjust names/passwords):

```sql
CREATE DATABASE mumbai_home_visit CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mumbai'@'localhost' IDENTIFIED BY 'use_a_strong_random_password';
GRANT ALL PRIVILEGES ON mumbai_home_visit.* TO 'mumbai'@'localhost';
FLUSH PRIVILEGES;
```

2. In production `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mumbai_home_visit
DB_USERNAME=mumbai
DB_PASSWORD=use_a_strong_random_password
```

3. If the DB is on another host or uses SSL, set `DB_HOST` / `DB_URL` and any SSL vars your host documents.

### PostgreSQL example

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mumbai_home_visit
DB_USERNAME=mumbai
DB_PASSWORD=use_a_strong_random_password
```

### SQLite (if you still use it)

- Point `DB_DATABASE` to an absolute path on local disk (not synced/NFS if possible).
- Ensure the file is readable/writable by the PHP-FPM user.
- Install `php8.4-sqlite3`.

```env
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/mumbai-home-visit/database/database.sqlite
```

Create the file once: `touch database/database.sqlite` and run migrations.

---

## 3. Production `.env` checklist

Copy from `.env.example`, then set at least:

| Variable | Production value |
|----------|------------------|
| `APP_NAME` | Your site name |
| `APP_ENV` | `production` |
| `APP_KEY` | Output of `php artisan key:generate` (never commit real keys) |
| `APP_DEBUG` | **`false`** |
| `APP_URL` | **`https://your-domain.com`** (must match public URL) |
| `DB_*` | As in section 2 |
| `SESSION_DRIVER` | `database` or `redis` if multiple servers; `file` only for single server |
| `CACHE_STORE` | `database` or `redis` recommended at scale |
| `QUEUE_CONNECTION` | `database` or `redis` if you use queues; run a worker |
| `LOG_CHANNEL` / `LOG_LEVEL` | e.g. `stack` / `info` or `warning` |
| `MAIL_*` | Real SMTP or provider (Mailgun, SES, etc.) |
| `CORS_ALLOWED_ORIGINS` | Only if browsers call `/api/*` from other origins |

Generate key on the server:

```bash
php artisan key:generate --force
```

Optimize config (after `.env` is final):

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache   # if applicable
```

---

## 4. Deploy steps (first time)

From the directory that will be the app root (e.g. `/var/www/mumbai-home-visit`):

```bash
# Code (git clone, rsync, or your pipeline artifact)
git clone <your-repo> .
# or upload release artifact

# PHP dependencies (no dev packages in production)
php8.4 "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction

# Front-end build (on build host or here if Node is installed)
npm ci
npm run build

# Environment
cp .env.example .env
nano .env   # set production values; never commit .env

php artisan key:generate --force

# Database
php artisan migrate --force

# Optional: admin user — only if your seeder is safe for production
# php artisan db:seed --force   # review DatabaseSeeder first

# Storage
php artisan storage:link

# Permissions (adjust user/group to your PHP-FPM user, e.g. www-data)
sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;
```

**Filament admin:** usually `/admin`. Create an admin user via your seeder or `php artisan make:filament-user` (Filament docs) — do **not** leave default demo passwords.

---

## 5. Nginx (minimal example)

Point `root` to **`public`**, pass PHP to FPM:

```nginx
server {
    listen 443 ssl http2;
    server_name your-domain.com;
    root /var/www/mumbai-home-visit/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Adjust `fastcgi_pass` to match your distro (socket path or `127.0.0.1:9000`).

---

## 6. Queue worker (if not `sync`)

Example **Supervisor** program:

```ini
[program:mumbai-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/mumbai-home-visit/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/mumbai-home-visit/storage/logs/queue.log
```

---

## 7. Scheduler (cron)

Crontab for the deploy user (often `www-data` or a deploy user):

```cron
* * * * * cd /var/www/mumbai-home-visit && php artisan schedule:run >> /dev/null 2>&1
```

---

## 8. Security and operations

- **`APP_DEBUG=false`** always in production.
- **HTTPS only**; set `APP_URL` with `https://`.
- **Secrets** only in `.env` or host secret manager — never in git.
- **Dependencies:** run `composer audit` and keep PHP/OS patched.
- **Backups:** database dumps + `storage/app` (uploads) on a schedule.
- **Filament:** restrict `/admin` by IP or VPN if possible; enforce 2FA if Filament supports it for your version.

---

## 9. Updating the app (later releases)

```bash
git pull   # or deploy new artifact
php8.4 "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction
npm ci && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
# restart php-fpm and queue workers
```

---

## 10. Hosted platforms

If you use **Laravel Forge**, **Ploi**, **Railway**, **Fly.io**, **AWS Elastic Beanstalk**, etc., map this guide to their UI: same requirements — **PHP 8.4**, **Composer**, **build assets**, **`public` as web root**, **`.env`**, **migrations**, **queue/cron** as needed.

For local parity with production, use the same `DB_CONNECTION` where possible and run `php artisan test` before deploying.
