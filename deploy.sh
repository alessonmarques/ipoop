#!/bin/bash

# Caminho do projeto
PROJECT_DIR="/var/www/ipoop.app.br/ipoop"
cd "$PROJECT_DIR"

# Log
echo "===== Iniciando deploy: $(date) =====" >> /tmp/deploy.log

# Reset para evitar conflitos
echo "🧹 Limpando repositório..."
git reset --hard
git clean -fd

# Puxa da branch production
echo "📦 Puxando da branch production..."
git checkout production >> /tmp/deploy.log 2>&1
git pull origin production >> /tmp/deploy.log 2>&1

# Permissões
echo "🔒 Ajustando permissões..."
chown -R :deploy "$PROJECT_DIR"
chmod -R 775 "$PROJECT_DIR"
sudo find "$PROJECT_DIR" -type d -exec chmod g+s {} \;

# Composer (instala dependências)
echo "📦 Rodando composer install..."
composer install --no-dev --optimize-autoloader --no-interaction >> /tmp/deploy.log 2>&1

# Migrations
echo "🗄️ Rodando migrations..."
php artisan migrate --force >> /tmp/deploy.log 2>&1

# run npm
echo "🧱 Rodando npm install..."
npm install --no-audit --prefer-offline --no-fund >> /tmp/deploy.log 2>&1

echo "🛠️ Rodando vite build..."
npm run build >> /tmp/deploy.log 2>&1


# Vite build
echo "🛠️ Rodando vite build..."
npm ci --omit=dev
npm run build

# Symlink storage
echo "🔗 Criando symlink de storage..."
php artisan storage:link >> /tmp/deploy.log 2>&1

# Caches
echo "🗄️ Limpando caches..."
php artisan route:clear
php artisan view:clear
php artisan config:clear

echo "===== Deploy finalizado: $(date) =====" >> /tmp/deploy.log
