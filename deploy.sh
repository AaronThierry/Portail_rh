#!/bin/bash
# Script de deploiement VPS - Portail RH+
# Usage: bash deploy.sh

echo "=========================================="
echo "  DEPLOIEMENT PORTAIL RH+"
echo "=========================================="

echo ""
echo "[1/9] Git pull..."
git pull origin main

echo ""
echo "[2/9] Installation des dependances PHP..."
composer install --no-dev --optimize-autoloader

echo ""
echo "[3/9] Nettoyage de TOUS les caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan event:clear 2>/dev/null || true

echo ""
echo "[4/9] Verification APP_KEY..."
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
    echo "  -> Generation de la cle APP_KEY..."
    php artisan key:generate --force
fi

echo ""
echo "[5/9] Migrations base de donnees..."
php artisan migrate --force

echo ""
echo "[6/9] Roles, permissions et Super Admin..."
php artisan db:seed --class=RolesAndPermissionsSeeder --force 2>/dev/null || echo "  -> RolesAndPermissionsSeeder deja execute ou erreur (non bloquant)"
php artisan db:seed --class=SuperAdminSeeder --force

echo ""
echo "[7/9] Lien symbolique storage..."
php artisan storage:link 2>/dev/null || true

echo ""
echo "[8/9] Permissions fichiers..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
mkdir -p storage/app/dossiers_agents
mkdir -p storage/app/public/bulletins-paie
chmod -R 775 storage/app/dossiers_agents storage/app/public/bulletins-paie

echo ""
echo "[9/9] Rebuild cache optimise..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "=========================================="
echo "  DEPLOIEMENT TERMINE AVEC SUCCES"
echo "=========================================="
echo ""
echo "  Email:        admin@portail-rh.com"
echo "  Mot de passe: Admin@2025"
echo ""
echo "  IMPORTANT: Changez le mot de passe apres la premiere connexion!"
echo "=========================================="
