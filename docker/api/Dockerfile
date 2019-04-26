FROM php:7.3-fpm

RUN pecl install redis-4.0.1 \
    && docker-php-ext-enable redis

RUN docker-php-ext-install mbstring pdo_mysql

WORKDIR /var/www/collective-times/api

EXPOSE 9000
