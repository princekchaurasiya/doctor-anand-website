# Share the site with clients (GitHub Pages)

After you push to `main`, GitHub Actions builds a **static copy** of the marketing site and publishes it at:

**https://princekchaurasiya.github.io/doconnect-react-website/**

This matches the pattern used for [Express Logistics](https://princekchaurasiya.github.io/express-logistics/).

## One-time setup on GitHub

1. Push to `main` (or run **Deploy GitHub Pages** under **Actions**). The workflow creates/updates the `gh-pages` branch.
2. Open **https://github.com/princekchaurasiya/doconnect-react-website/settings/pages**
3. Under **Build and deployment**, set **Source** to **Deploy from a branch**.
4. Choose branch **`gh-pages`**, folder **`/ (root)`**, then **Save**.

The site URL appears at the top of that settings page after a minute or two.

## What works on the public demo

- Home, About, Team, Testimonials, FAQs, Services, Blog, Contact pages
- Navigation between pages (full page loads)
- Seeded images and blog content

## Limitations (static hosting)

- **Contact form** does not submit (no PHP on GitHub Pages).
- **Admin / Filament** is not deployed (`/admin` is not included).
- Content updates require a new push to `main` (rebuild + redeploy).

For a full Laravel app (forms, admin, database), use a PHP host — see `PRODUCTION.md`.

## Local preview of the static export

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link

export APP_URL=http://127.0.0.1:8000
export STATIC_BASE_PATH=
export GITHUB_PAGES=true
export GITHUB_REPOSITORY=princekchaurasiya/doconnect-react-website

npm run build:pages
php artisan serve &
php artisan site:export-static
npx --yes serve static-export -p 4173
```

Open http://localhost:4173 (root only; for subpath behaviour use the GitHub URL after deploy).
