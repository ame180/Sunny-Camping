# Sunny Camping

Admin app for a small family campsite: guest register, billing and reports. Laravel 13 + Vue 3.

## Development

1. Copy `.env.example` to `.env`.
2. `docker compose up -d` (installs dependencies and builds assets).
3. `docker compose exec php php artisan db:seed` (first run only).
4. `git config core.hooksPath scripts/git-hooks`

The admin panel is at http://localhost/admin. Run `php` and `yarn` commands inside the `php` container, never on the host: `node_modules` is shared through the bind mount, and a host install replaces the container's native binaries. `yarn dev` serves assets with hot reload on port 5173.

Tests: `php artisan test` (uses its own in-memory database container, no setup). Style: `php bin/php-cs-fixer fix`.

## Deployment

Run the Deploy workflow from `main`. It builds the images, pushes them to GHCR and redeploys over SSH. It needs the `prod` environment secrets `SSH_HOST`, `SSH_USER`, `SSH_KEY` and `APP_PATH`.
