#!/bin/sh

set -e

APP_PATH="/var/www/symfony"
echo "all params $@"

echo "running startup"

composer install
# php ${APP_PATH}/bin/console doctrine:migrations:migrate --no-interaction
php ${APP_PATH}/bin/console assets:install

echo "starting php-fpm"
exec $@
