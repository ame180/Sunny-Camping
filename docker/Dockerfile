FROM ubuntu:20.04
ARG DEBIAN_FRONTEND=noninteractive

RUN apt update && apt install -y apache2
RUN apt install -y software-properties-common && add-apt-repository ppa:ondrej/php
RUN apt install -y php8.0 libapache2-mod-php8.0

RUN service apache2 start
