FROM composer:2.7.2
FROM php:8.3.4-fpm-alpine3.19
COPY --from=0 /usr/bin/composer /usr/bin/patch /usr/bin/
COPY composer.json /var/www/html/composer.json
COPY mqtt-client-loop-fix.patch /opt/
RUN apk add --no-cache linux-headers \
    && docker-php-ext-install pdo pdo_mysql sockets \
    && composer require php-mqtt/client \
    && composer update \
    && composer install \
    && patch -d /var/www/vendor -p0 < /opt/mqtt-client-loop-fix.patch
