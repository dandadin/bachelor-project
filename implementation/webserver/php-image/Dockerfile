FROM composer:2.7.2
FROM php:8.3.4-fpm-alpine3.19
COPY --from=0 /usr/bin/composer /usr/bin/composer
COPY composer.json /var/www/html/composer.json
RUN docker-php-ext-install pdo pdo_mysql \
    && composer require php-mqtt/client \
    && composer update \
    && composer install
