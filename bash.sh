composer install
chown -R www-data:www-data /application/storage/logs /application/storage/framework /application/bootstrap/cache
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan test
