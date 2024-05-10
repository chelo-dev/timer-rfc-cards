#!/bin/bash

# Este escrip limpia la cache de Laravel.

php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
php artisan clear-compiled
php artisan queue:restart
composer dump-autoload
echo "Todo bien! Se limipo la cache"
exit
