FROM php:7.3-fpm

RUN apt-get -qq update \
      && apt-get -qq install -y --no-install-recommends unzip zlib1g-dev git

RUN pecl install redis-4.0.1 \
    && docker-php-ext-enable redis

RUN docker-php-ext-install mbstring pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer -q config -g repositories.packagist composer https://packagist.jp
RUN composer -q global require hirak/prestissimo

WORKDIR /var/www/collective-times/api

EXPOSE 9000
