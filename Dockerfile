# Base PHP image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Install PHP dependencies (skip scripts to avoid DB dependency at build-time)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Generate app key and discover packages after install
RUN php artisan key:generate --force || true
RUN php artisan package:discover --ansi

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Optimize Laravel
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port
EXPOSE 8080

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
