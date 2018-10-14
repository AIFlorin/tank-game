FROM php:7-fpm-alpine
RUN docker-php-source extract \
    && apk add --update --virtual .build-deps autoconf g++ make pcre-dev icu-dev openssl-dev
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install pdo_mysql
