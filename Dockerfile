FROM php:7.4-fpm

MAINTAINER Tim Helfensdörfer <thelfensdrfer@gmail.com>

# Install extensions
RUN apt-get update && apt-get install \
    libzip-dev zip \
    libcurl4-openssl-dev pkg-config libssl-dev -y
RUN docker-php-ext-install -j$(nproc) pdo_mysql zip

RUN pecl install redis && docker-php-ext-enable redis

# Install git to allow sentry release tracking
RUN apt-get install git -y

# Install mysqldump for backups
RUN apt-get install default-mysql-client -y

RUN mkdir /app

WORKDIR /app

CMD ["php-fpm"]

EXPOSE 9000
