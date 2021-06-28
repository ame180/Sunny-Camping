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
