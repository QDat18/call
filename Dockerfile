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

RUN chown -R www-data:www-data storage bootstrap/cache

# Copy và cấp quyền cho script khởi động (giúp chạy cả Web và Queue)
COPY render-start.sh /usr/local/bin/render-start.sh
RUN chmod +x /usr/local/bin/render-start.sh

EXPOSE 8080
CMD ["/usr/local/bin/render-start.sh"]
