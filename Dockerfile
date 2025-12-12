FROM php:8.2-fpm

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

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Composer but disable post-scripts (avoid DB access)
RUN COMPOSER_ALLOW_SUPERUSER=1 \
    composer install --no-interaction --prefer-dist \
    --optimize-autoloader --no-scripts

# Clear caches (safe)
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# DO NOT RUN: package:discover (some providers query DB)
# DO NOT RUN: migrate, seed, optimize

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
