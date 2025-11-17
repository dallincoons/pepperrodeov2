# PHP 8.3, multi-arch (works on Apple Silicon)
FROM php:8.3-fpm

# System deps
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libzip-dev zip unzip \
    libonig-dev libxml2-dev \
    git curl vim \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Workdir
WORKDIR /var/www

# Copy only composer files first (better layer caching)
COPY composer.lock composer.json ./

# (Optional) install vendors at build time; comment out if you prefer runtime install
# RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

# Copy app and set ownership to www-data
COPY --chown=www-data:www-data . .

# Run as the built-in PHP user
USER www-data

EXPOSE 9000
CMD ["php-fpm"]
