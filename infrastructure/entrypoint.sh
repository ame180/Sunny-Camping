#!/bin/bash

chmod -R 777 storage/

composer install
npm install
npm run dev

php artisan migrate

php-fpm
