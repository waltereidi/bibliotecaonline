#!/bin/bash
echo "🚀 Executando docker-script.sh..."
cd  /var/www/html/bibliotecaonline
composer install --no-interaction --no-plugins --no-scripts

composer global require laravel/installer

exec "$@"
