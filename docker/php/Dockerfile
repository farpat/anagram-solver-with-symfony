FROM php:7.4-fpm

# Installation of composer
RUN apt-get update && apt-get install -y curl zip unzip && \
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

ENV COMPOSER_CACHE_DIR=/.cache/composer
