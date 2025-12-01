#!/bin/sh

# Entrypoint script untuk Laravel di Koyeb
# Script ini akan dijalankan setiap kali container start

echo "🚀 Starting Laravel application..."

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
until php artisan migrate:status &>/dev/null; do
    echo "Database is unavailable - sleeping"
    sleep 2
done

echo "✅ Database is ready!"

# Run migrations
echo "📊 Running database migrations..."
php artisan migrate --force

# Clear and optimize
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
if [ ! -L public/storage ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✨ Application is ready!"

# Execute the main command (from CMD in Dockerfile)
exec "$@"
