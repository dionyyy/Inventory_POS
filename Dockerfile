# syntax=docker/dockerfile:1

###############################################################################
# Base image: PHP 8.3 FPM with the extensions this Laravel 12 app needs.
###############################################################################
FROM php:8.4-fpm-bookworm AS base

# System packages required to build PHP extensions and run the app.
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        gd \
        bcmath \
        zip \
        exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer (copied from the official Composer image).
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Match the container user to the typical host UID/GID to avoid permission
# problems on bind-mounted volumes during local development.
ARG UID=1000
ARG GID=1000
RUN groupmod -o -g "${GID}" www-data \
    && usermod -o -u "${UID}" -g www-data www-data

###############################################################################
# Development stage: dependencies are installed at runtime via the entrypoint
# so the bind-mounted source stays authoritative.
###############################################################################
FROM base AS development

COPY docker/php/local.ini /usr/local/etc/php/conf.d/zz-local.ini
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

USER www-data

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]
