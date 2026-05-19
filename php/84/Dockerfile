FROM php:8.4-apache

RUN echo "deb http://archive.debian.org/debian stretch main contrib non-free" > /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian-security stretch/updates main contrib non-free" >> /etc/apt/sources.list && \
    printf "Acquire::Check-Valid-Until \"false\";\nAcquire::AllowInsecureRepositories \"true\";\nAcquire::AllowUnauthenticated \"true\";\n" > /etc/apt/apt.conf.d/99archive && \
    apt update && \
    apt install -y --allow-unauthenticated curl unzip git

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Apache rewrite
RUN a2enmod rewrite