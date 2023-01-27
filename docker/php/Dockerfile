FROM php:8.0-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    bash \
    curl \
    libc-dev \
    libtool \
    libzip-dev \
    icu-dev \
    zlib-dev

# Install PECL and PEAR extensions
RUN pecl install \
    xdebug
# Install and enable php extensions
RUN docker-php-ext-enable \
    xdebug

RUN curl -sS https://getcomposer.org/installer | \
    php -- --filename=composer --install-dir=/usr/local/bin

WORKDIR /home/app/code
