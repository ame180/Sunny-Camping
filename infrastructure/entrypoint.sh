#!/bin/bash

chmod -R 777 storage/

composer install
npm ci
npm run dev

php artisan migrate

php-fpm
