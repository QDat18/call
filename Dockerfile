# Base PHP
FROM php:8.2-cli

# Install system dependencies + CA certificates (fix SSL)
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip npm \
    libpng-dev libjpeg-dev libfreetype6-dev \
    ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql zip gd bcmath exif

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy source code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node + build frontend (Vite)
RUN npm install && npm run build

# Expose port (Render dùng 10000)
EXPOSE 10000

# Start app (QUAN TRỌNG)
CMD php artisan config:clear && php artisan serve --host=0.0.0.0 --port=10000
