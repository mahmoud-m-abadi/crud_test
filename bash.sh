composer install
chwon -R www-data:www-data storage/logs storage/framework
cp .env.example .env
php artisan key:generate
php artisan test
