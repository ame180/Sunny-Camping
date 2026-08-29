FROM php:8.3-fpm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install NodeJS
RUN curl -L https://raw.githubusercontent.com/tj/n/master/bin/n -o n && bash n v20
RUN npm install --global yarn

# Install Packages
RUN apt-get update && apt-get install -y mariadb-client git zip python3 && apt-get clean

# Install PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql

COPY . /application
WORKDIR /application
