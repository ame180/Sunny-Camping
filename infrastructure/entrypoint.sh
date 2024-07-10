#!/bin/bash

chmod -R 777 storage/

composer install
yarn install
yarn dev

php artisan migrate

service cron start

php-fpm
