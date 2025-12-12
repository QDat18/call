# Base PHP image
FROM php:8.2-fpm

# System dependencies
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

# Working directory
WORKDIR /var/www/html

# Copy source
COPY . .

# Composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Build cache
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Expose port 8080 for internal usage
EXPOSE 8080

# Default command (overridden by Procfile)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
