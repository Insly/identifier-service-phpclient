ARG PHP_VERSION=8.0
FROM ghcr.io/blumilksoftware/php:${PHP_VERSION}

ARG XDEBUG_VERSION=3.1.2
ARG INSTALL_XDEBUG=false
ARG XDEBUG_CLIENT_HOST=host.docker.internal
ARG XDEBUG_CLIENT_PORT=9003
ARG XDEBUG_START_WITH_REQUEST=yes
ARG XDEBUG_MODE=debug

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk --no-cache add $PHPIZE_DEPS \
    && pecl install xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=${XDEBUG_CLIENT_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
;fi
