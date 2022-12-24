FROM php:8.1.8-fpm

ARG UID=1000

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
    && apt-get install -y \
        libpq-dev libzip-dev \
        curl wget nano mc \
        sudo cron git \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql

RUN groupadd -g "$UID" app \
    && useradd -g "$UID" -u "$UID" -d /home/app -s /bin/bash app \
    && usermod -aG sudo,www-data app \
    && echo "app ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /home/app/.composer \
    && chown -R app:app /home/app

USER app
WORKDIR /var/www/html
