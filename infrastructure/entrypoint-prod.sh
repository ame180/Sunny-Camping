#!/bin/bash
set -e

chmod -R 777 storage bootstrap/cache

php artisan migrate --force

service cron start

exec php-fpm
