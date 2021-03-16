FROM ubuntu:20.04
ARG DEBIAN_FRONTEND=noninteractive

# Install PHP 8.0 and all necessary extensions
RUN apt-get update
RUN apt-get install -y software-properties-common && add-apt-repository ppa:ondrej/php
RUN apt-get install -y php8.0 php8.0-fpm php8.0-xml php8.0-mysql curl

# Install NodeJS
RUN curl -L https://raw.githubusercontent.com/tj/n/master/bin/n -o n
RUN bash n lts

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
