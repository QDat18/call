web: php artisan storage:link && php artisan db:seed --force && php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
worker: php artisan queue:work --tries=3 --timeout=90
