#!/bin/sh

# Tạo liên kết Storage (để hiện ảnh)
echo "Linking storage..."
php artisan storage:link --force

# Khởi động Queue worker ở chế độ chạy ngầm
echo "Starting Queue Worker..."
php artisan queue:work --daemon --tries=3 --timeout=90 &

# Khởi động Web Server trên cổng 8080
echo "Starting Web Server on port 8080..."
php artisan serve --host=0.0.0.0 --port=8080
