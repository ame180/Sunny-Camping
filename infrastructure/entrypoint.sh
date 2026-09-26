#!/bin/bash

chmod -R 777 storage/

composer install
yarn install
yarn build

php artisan migrate

php-fpm
