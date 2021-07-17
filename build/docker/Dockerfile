FROM php:8.0.8-fpm

ENV TZ America/Sao_Paulo
ENV HOME=/var/www
ENV USER=www-data

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip tzdata \
    && docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN usermod -u 1000 $USER

# Get 2 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN chown -R $USER:$USER $HOME

WORKDIR $HOME

USER $USER

COPY database/ database/

COPY --chown=$USER:$USER composer.* ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --ignore-platform-reqs \
    --no-interaction \
    # --no-plugins \
    --prefer-dist

COPY --chown=$USER:$USER . .

RUN composer dump-autoload --optimize
