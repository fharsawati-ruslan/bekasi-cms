!/bin/bash

echo "🔄 Clearing Laravel cache..."

php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan queue:restart

rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*.php
rm -rf storage/framework/sessions/*

echo "📦 Dump autoload..."
composer dump-autoload

echo "✅ Done! Alhamdulilah semoga lancar
