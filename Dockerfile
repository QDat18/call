# --- Base PHP image ---
FROM php:8.2-fpm

# --- Install system dependencies ---
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# --- PHP extensions ---
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql mbstring zip gd

# --- Install Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Set working directory ---
WORKDIR /var/www

# --- Copy app files ---
COPY . .

# --- Install dependencies ---
RUN composer install --no-dev --optimize-autoloader

# --- Laravel optimize ---
RUN php artisan key:generate --force || true
RUN php artisan storage:link || true
RUN php artisan optimize:clear

# --- Give permissions ---
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# --- Expose port (Railway uses 8080) ---
EXPOSE 8080

# --- Start Laravel ---
CMD php artisan serve --host=0.0.0.0 --port=8080
