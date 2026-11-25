# Sunny Camping

Admin app for a small family campsite: guest register, billing and reports. Laravel 13 + Vue 3.

## Development

1. Copy `.env.example` to `.env`.
2. `docker compose up -d` (installs dependencies and builds assets).
3. `docker compose exec php php artisan db:seed` (first run only).
4. `git config core.hooksPath scripts/git-hooks`

The admin panel is at http://localhost/admin. Run `php` and `yarn` commands inside the `php` container (`docker compose exec php bash` opens a shell), never on the host: `node_modules` is shared through the bind mount, and a host install replaces the container's native binaries. `yarn dev` serves assets with hot reload on port 5173; once it stops, pages fall back to the built assets.

Tests: `php artisan test`. They run against their own in-memory database container, configured in `.env.testing`, so the development database is never touched and no setup is needed. Style: `php bin/php-cs-fixer fix` (`--dry-run` to only check).

## Deployment

Deploys run through the manually triggered `Deploy` workflow (`.github/workflows/deploy.yml`), from `main`:

1. GitHub Actions installs frontend dependencies and compiles production assets.
2. It builds immutable production images from `infrastructure/Dockerfile-prod`.
3. It pushes them to GitHub Container Registry as `ghcr.io/ame180/sunny-camping-app` and `ghcr.io/ame180/sunny-camping-nginx`.
4. It uploads a rendered `compose.yml` to the server and restarts the services with `docker compose`.

It needs these secrets in the `prod` GitHub environment:

- `SSH_HOST`
- `SSH_USER`
- `SSH_KEY`
- `APP_PATH` (target directory on the server)
