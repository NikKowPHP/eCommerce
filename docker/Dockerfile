FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    && docker-php-ext-install pdo_mysql
RUN useradd -ms /bin/bash shop
USER shop

WORKDIR /var/www