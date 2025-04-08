#!/bin/bash

# Caminho do projeto
PROJECT_DIR="/var/www/ipoop.app.br/ipoop"
cd "$PROJECT_DIR"

# Log
echo "===== Iniciando deploy: $(date) =====" >> /tmp/deploy.log

# Reset para evitar conflitos
git reset --hard
git clean -fd

# Puxa da branch production
git pull origin production >> /tmp/deploy.log 2>&1

# Permissões
chown -R www-data:www-data "$PROJECT_DIR"

# Composer (instala dependências)
composer install --no-dev --optimize-autoloader >> /tmp/deploy.log 2>&1

# Migrations
php artisan migrate --force >> /tmp/deploy.log 2>&1

# run npm
npm install --production --no-audit --prefer-offline --no-fund >> /tmp/deploy.log 2>&1
npm run build >> /tmp/deploy.log 2>&1

# Vite build
npm ci --omit=dev
npm run build

# Symlink storage
php artisan storage:link >> /tmp/deploy.log 2>&1

# Caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan cors:clear

echo "===== Deploy finalizado: $(date) =====" >> /tmp/deploy.log
