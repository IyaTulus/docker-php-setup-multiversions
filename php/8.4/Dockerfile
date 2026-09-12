FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

RUN docker-php-ext-install -j"$(nproc)" gd

# Database
RUN docker-php-ext-install -j"$(nproc)" \
    pdo_mysql \
    mysqli

# Laravel requirements
RUN docker-php-ext-install -j"$(nproc)" \
    mbstring \
    bcmath \
    intl \
    zip \
    pcntl \
    exif

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www