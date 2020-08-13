FROM php:7.4-cli

MAINTAINER Tim Helfensdörfer <thelfensdrfer@gmail.com>

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Install extensions
RUN apt-get update && apt-get install unzip \
    libpng-dev \
    libtidy-dev \
    libmagickwand-dev \
    libzip-dev \
    libcurl4-openssl-dev pkg-config libssl-dev -y
RUN docker-php-ext-install -j$(nproc) gd tidy pdo_mysql zip bcmath intl
RUN pecl install ast mongodb imagick
RUN docker-php-ext-enable ast mongodb imagick

WORKDIR /app

ENTRYPOINT ["composer"]

CMD ["install", "--no-ansi", "--no-interaction", "--no-progress", "--no-scripts", "--optimize-autoloader", "--no-dev"]
