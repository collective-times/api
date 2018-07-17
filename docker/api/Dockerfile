FROM php:7.2-fpm

RUN pecl install -o -f xdebug \
    && docker-php-ext-enable xdebug
RUN docker-php-ext-install mbstring pdo_mysql

WORKDIR /var/www/collective-times/api

EXPOSE 9000
