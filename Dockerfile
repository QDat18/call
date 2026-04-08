# Base PHP
FROM php:8.2-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip npm \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_pgsql zip gd bcmath exif

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /app

# Copy code
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Install Node deps & build Vite
RUN npm install && npm run build

# Laravel optimize
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Expose port
EXPOSE 10000

# Start server
CMD php artisan serve --host=0.0.0.0 --port=10000
