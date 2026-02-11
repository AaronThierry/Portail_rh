#!/bin/bash
# Script de deploiement VPS - Portail RH+
# Usage: bash deploy.sh

set -e

echo "=== Deploiement Portail RH+ ==="

echo "1. Git pull..."
git pull origin main

echo "2. Installation des dependances PHP..."
composer install --no-dev --optimize-autoloader

echo "3. Nettoyage de tous les caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "4. Migrations base de donnees..."
php artisan migrate --force

echo "5. Permissions storage et cache..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "6. Lien symbolique storage..."
php artisan storage:link 2>/dev/null || true

echo "7. Creation du compte Super Admin..."
php artisan db:seed --class=SuperAdminSeeder --force

echo "8. Rebuild du cache optimise..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "=== Deploiement termine ==="
echo "Email: admin@portail-rh.com"
echo "Mot de passe: Admin@2025"
