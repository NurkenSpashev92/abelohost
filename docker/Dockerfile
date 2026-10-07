FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/pear

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY conf/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug-dev.ini

RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/html

USER www
