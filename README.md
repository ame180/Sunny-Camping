# Sunny Camping

## Installation

1. Clone the repository
2. Copy `.env.example` to `.env`
3. Run `docker-compose build`
4. Add `127.0.0.1 sunnycamping.local` to your `hosts` file

## Usage

### Starting the project

To start the project, run `docker-compose up -d`. This will automatically install dev dependencies
and compile assets for dev environment.

Now, to access the main application container (`php-fpm`), run `docker-compose exec php-fpm bash`, and to
access the website, connect to `sunnycamping.local`.

If you're running the project for the first time, you should run `php artisan db:seed`
inside the main container, to fill the database with example data.

*All the commands below are supposed to run inside the `php-fpm` container.*

### Useful commands

- To fix style, run `php bin/php-cs-fixer fix`

### Testing

- To run application tests, run `php artisan test`
- To run style tests, run `php bin/php-cs-fixer fix --dry-run`

## Deployment (GitHub Actions)

Deployment is now handled by the `Deploy` workflow in `.github/workflows/deploy.yml`.

### Flow

1. Run the workflow manually and choose the `dev` or `prod` environment.
2. GitHub Actions installs frontend dependencies and compiles production assets.
3. GitHub Actions builds immutable production images from `infrastructure/Dockerfile-prod`.
4. Images are pushed to GitHub Container Registry as `ghcr.io/ame180/sunny-camping-app` and `ghcr.io/ame180/sunny-camping-nginx`.
5. The workflow uploads a rendered `docker-compose-prod.yml` to the server and restarts services with `docker compose`.

### Required GitHub Environment Secrets

Set these secrets in each GitHub environment (`dev` and `prod`):

- `SSH_HOST`
- `SSH_USER`
- `SSH_KEY`
- `APP_PATH` (target directory on the server)

Both environments can point to the same host while using different `APP_PATH` values.
