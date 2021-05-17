ARG PHP_VERSION=7.2

FROM php:${PHP_VERSION}-fpm-alpine

ARG COMPOSER_VERSION=2.0.13

RUN apk update && apk upgrade \
    && apk add --no-cache icu-dev \
    && curl -sS https://getcomposer.org/installer | php -- --version="${COMPOSER_VERSION}" --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl