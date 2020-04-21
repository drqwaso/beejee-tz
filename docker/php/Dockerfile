FROM php:7.2-fpm
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql mysqli


RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
        libmcrypt-dev \
        libpng-dev \
        libjpeg-dev \
        libpng-dev \
        vim \
    && docker-php-ext-install iconv \
    && docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/freetype2 \
        --with-png-dir=/usr/include \
        --with-jpeg-dir=/usr/include \
    && docker-php-ext-install gd \
    && docker-php-ext-install mbstring \
    && docker-php-ext-enable opcache gd \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www
