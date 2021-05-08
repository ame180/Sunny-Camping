#!/bin/bash

composer install
npm run dev

php artisan migrate

php-fpm
