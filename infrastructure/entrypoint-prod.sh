#!/bin/bash
set -e

# Fresh named volumes start empty, so initialize Laravel runtime paths.
mkdir -p \
	storage/framework/cache/data \
	storage/framework/sessions \
	storage/framework/views \
	storage/logs \
	storage/app/public

chmod -R 777 storage bootstrap/cache

php artisan migrate --force

service cron start

exec php-fpm
