#!/bin/bash

composer install
npm install
npm run dev

php artisan migrate

php-fpm
