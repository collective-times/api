FROM php:7.4-fpm

RUN apt-get -qq update \
      && apt-get -qq install -y --no-install-recommends unzip zlib1g-dev git libonig-dev

RUN pecl install redis-4.0.1 \
    && docker-php-ext-enable redis

RUN docker-php-ext-install mbstring pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
WORKDIR /var/www/collective-times/api

EXPOSE 9000
