FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

COPY ./src /var/www/html/

RUN chown -R www-data:www-data /var/www/html