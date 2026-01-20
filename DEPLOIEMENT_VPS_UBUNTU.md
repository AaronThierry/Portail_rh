# Guide de Déploiement - Portail RH

## Informations du serveur

| Élément | Valeur |
|---------|--------|
| **Domaine** | srv1281294.hstgr.cloud |
| **URL Production** | https://srv1281294.hstgr.cloud |
| **IP** | 72.62.190.57 |
| **Hébergeur** | Hostinger VPS (KVM 4) |
| **OS** | Ubuntu 24.04 LTS |
| **Chemin projet** | /var/www/portail_rh |
| **Repository** | https://github.com/AaronThierry/Portail_rh.git |
| **PHP** | 8.2 |
| **Node.js** | 20.x |

---

## 1. Configuration initiale du VPS

### 1.1 Connexion au VPS

```bash
ssh root@72.62.190.57
```

Ou avec le nom d'hôte :

```bash
ssh root@srv1281294.hstgr.cloud
```

### 1.2 Mise à jour du système

```bash
apt update && apt upgrade -y
```

### 1.3 Installation des dépendances

```bash
# PHP 8.2 et extensions requises
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath php8.2-intl php8.2-readline

# Nginx
apt install -y nginx

# MySQL
apt install -y mysql-server

# Git
apt install -y git

# Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Node.js 20.x
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

# Vérification des versions
php -v
composer -V
node -v
npm -v
```

---

## 2. Configuration de la base de données

### 2.1 Sécuriser MySQL

```bash
mysql_secure_installation
```

Répondez aux questions :
- Validate Password: **N** (ou Y si vous voulez des mots de passe complexes)
- Remove anonymous users: **Y**
- Disallow root login remotely: **Y**
- Remove test database: **Y**
- Reload privilege tables: **Y**

### 2.2 Créer la base de données et l'utilisateur

```bash
mysql -u root -p
```

```sql
CREATE DATABASE portail_rh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'portail_user'@'localhost' IDENTIFIED BY 'VOTRE_MOT_DE_PASSE_SECURISE';
GRANT ALL PRIVILEGES ON portail_rh.* TO 'portail_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> **IMPORTANT** : Remplacez `VOTRE_MOT_DE_PASSE_SECURISE` par un mot de passe fort (générez-en un avec `openssl rand -base64 32`)

---

## 3. Clonage et configuration du projet

### 3.1 Cloner le repository

```bash
cd /var/www
git clone https://github.com/AaronThierry/Portail_rh.git portail_rh
cd portail_rh
```

### 3.2 Configurer les permissions

```bash
chown -R www-data:www-data /var/www/portail_rh
chmod -R 755 /var/www/portail_rh
chmod -R 775 /var/www/portail_rh/storage
chmod -R 775 /var/www/portail_rh/bootstrap/cache
```

### 3.3 Installer les dépendances PHP

```bash
cd /var/www/portail_rh
composer install --optimize-autoloader --no-dev
```

### 3.4 Installer les dépendances Node.js et compiler les assets

```bash
npm install
npm run build
```

### 3.5 Configuration de l'environnement

```bash
cp .env.example .env
nano .env
```

Contenu du fichier `.env` (à adapter) :

```env
APP_NAME="Portail RH"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://srv1281294.hstgr.cloud

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portail_rh
DB_USERNAME=portail_user
DB_PASSWORD=VOTRE_MOT_DE_PASSE_SECURISE

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuration Email (à adapter selon votre fournisseur)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=contact@votre-domaine.com
MAIL_PASSWORD=votre_mot_de_passe_email
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="noreply@votre-domaine.com"
MAIL_FROM_NAME="${APP_NAME}"

# Twilio WhatsApp (optionnel)
TWILIO_WHATSAPP_ENABLED=false
TWILIO_SID=
TWILIO_AUTH_TOKEN=
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886
```

### 3.6 Finaliser l'installation Laravel

```bash
# Générer la clé d'application
php artisan key:generate

# Créer le lien symbolique pour le stockage
php artisan storage:link

# Exécuter les migrations
php artisan migrate --force

# Si vous avez des seeders à exécuter
# php artisan db:seed --force

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Rétablir les permissions après les commandes artisan
chown -R www-data:www-data /var/www/portail_rh
chmod -R 775 /var/www/portail_rh/storage
chmod -R 775 /var/www/portail_rh/bootstrap/cache
```

---

## 4. Configuration de Nginx

### 4.1 Créer le fichier de configuration

```bash
nano /etc/nginx/sites-available/portail_rh
```

Contenu :

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name srv1281294.hstgr.cloud 72.62.190.57;
    root /var/www/portail_rh/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;
    charset utf-8;

    # Taille maximale des uploads (pour les documents RH)
    client_max_body_size 50M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache des assets statiques
    location ~* \.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### 4.2 Activer le site

```bash
# Créer le lien symbolique
ln -s /etc/nginx/sites-available/portail_rh /etc/nginx/sites-enabled/

# Supprimer le site par défaut
rm -f /etc/nginx/sites-enabled/default

# Tester la configuration
nginx -t

# Redémarrer Nginx
systemctl restart nginx
```

---

## 5. Configuration SSL avec Let's Encrypt

### 5.1 Installer Certbot

```bash
apt install -y certbot python3-certbot-nginx
```

### 5.2 Générer le certificat SSL

```bash
certbot --nginx -d srv1281294.hstgr.cloud
```

Suivez les instructions :
- Entrez votre email
- Acceptez les conditions
- Choisissez de rediriger HTTP vers HTTPS (option 2)

### 5.3 Vérifier le renouvellement automatique

```bash
certbot renew --dry-run
```

### 5.4 Configurer le renouvellement automatique (cron)

```bash
crontab -e
```

Ajoutez cette ligne :

```
0 3 * * * /usr/bin/certbot renew --quiet
```

---

## 6. Configuration du pare-feu (UFW)

```bash
# Autoriser SSH (important : ne pas bloquer votre accès !)
ufw allow 22

# Autoriser HTTP et HTTPS
ufw allow 80
ufw allow 443

# Activer le pare-feu
ufw enable

# Vérifier le statut
ufw status
```

---

## 7. Configuration PHP-FPM (optionnelle mais recommandée)

### 7.1 Optimiser PHP-FPM pour la production

```bash
nano /etc/php/8.2/fpm/pool.d/www.conf
```

Modifiez ces valeurs selon vos besoins (avec 16GB RAM) :

```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500
```

### 7.2 Configurer PHP pour la production

```bash
nano /etc/php/8.2/fpm/php.ini
```

Modifiez :

```ini
upload_max_filesize = 50M
post_max_size = 50M
memory_limit = 256M
max_execution_time = 300
expose_php = Off
```

Redémarrer PHP-FPM :

```bash
systemctl restart php8.2-fpm
```

---

## 8. Script de déploiement automatisé

### 8.1 Créer le script

```bash
nano /var/www/portail_rh/deploy.sh
```

Contenu :

```bash
#!/bin/bash
set -e

cd /var/www/portail_rh

echo "=========================================="
echo "  Déploiement Portail RH"
echo "  $(date)"
echo "=========================================="

echo ""
echo "[1/7] Activation du mode maintenance..."
php artisan down --render="errors::503"

echo ""
echo "[2/7] Récupération des modifications depuis GitHub..."
git pull origin main

echo ""
echo "[3/7] Installation des dépendances PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

echo ""
echo "[4/7] Installation des dépendances Node.js..."
npm ci --production=false

echo ""
echo "[5/7] Compilation des assets..."
npm run build

echo ""
echo "[6/7] Migration de la base de données..."
php artisan migrate --force

echo ""
echo "[7/7] Optimisation Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "Correction des permissions..."
chown -R www-data:www-data /var/www/portail_rh
chmod -R 775 storage bootstrap/cache

echo ""
echo "Désactivation du mode maintenance..."
php artisan up

echo ""
echo "=========================================="
echo "  Déploiement terminé avec succès !"
echo "=========================================="
```

### 8.2 Rendre le script exécutable

```bash
chmod +x /var/www/portail_rh/deploy.sh
```

---

## 9. Workflow de mise à jour quotidien

### Sur votre PC local (Windows)

```bash
# 1. Faire vos modifications dans le code

# 2. Commiter et pousser
git add -A
git commit -m "Description des modifications"
git push origin main
```

### Sur le VPS

```bash
# 3. Se connecter
ssh root@72.62.190.57

# 4. Exécuter le script de déploiement
cd /var/www/portail_rh
./deploy.sh
```

---

## 10. Commandes utiles

### Logs

```bash
# Logs Laravel
tail -100 /var/www/portail_rh/storage/logs/laravel.log

# Logs Laravel en temps réel
tail -f /var/www/portail_rh/storage/logs/laravel.log

# Logs Nginx
tail -50 /var/log/nginx/error.log
tail -50 /var/log/nginx/access.log
```

### Services

```bash
# Statut des services
systemctl status nginx
systemctl status php8.2-fpm
systemctl status mysql

# Redémarrer les services
systemctl restart nginx
systemctl restart php8.2-fpm
systemctl restart mysql
```

### Laravel

```bash
cd /var/www/portail_rh

# Vider tous les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Mode maintenance
php artisan down
php artisan up

# Mode debug temporaire
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
php artisan config:clear
# Après résolution du problème :
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
php artisan config:clear
```

### Base de données

```bash
# Sauvegarde
mysqldump -u portail_user -p portail_rh > /root/backup_portail_rh_$(date +%Y%m%d_%H%M%S).sql

# Restauration
mysql -u portail_user -p portail_rh < /root/backup_portail_rh_XXXXXXXX.sql
```

---

## 11. Sauvegardes automatiques

### 11.1 Créer le script de sauvegarde

```bash
nano /root/backup_portail_rh.sh
```

Contenu :

```bash
#!/bin/bash
BACKUP_DIR="/root/backups"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="portail_rh"
DB_USER="portail_user"
DB_PASS="VOTRE_MOT_DE_PASSE"

# Créer le répertoire de backup si nécessaire
mkdir -p $BACKUP_DIR

# Backup de la base de données
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_$DATE.sql

# Backup des fichiers uploadés
tar -czf $BACKUP_DIR/storage_$DATE.tar.gz /var/www/portail_rh/storage/app

# Supprimer les backups de plus de 30 jours
find $BACKUP_DIR -name "*.sql" -mtime +30 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +30 -delete

echo "Backup terminé : $DATE"
```

### 11.2 Planifier les sauvegardes

```bash
chmod +x /root/backup_portail_rh.sh
crontab -e
```

Ajoutez :

```
0 2 * * * /root/backup_portail_rh.sh >> /var/log/backup.log 2>&1
```

---

## 12. Dépannage

### Erreur 500

1. Vérifier les logs Laravel : `tail -100 /var/www/portail_rh/storage/logs/laravel.log`
2. Activer le mode debug temporairement
3. Vérifier les permissions : `ls -la storage/`

### Erreur "Vite manifest not found"

```bash
cd /var/www/portail_rh
npm install
npm run build
```

### Erreur de permissions

```bash
chown -R www-data:www-data /var/www/portail_rh
chmod -R 755 /var/www/portail_rh
chmod -R 775 storage bootstrap/cache
```

### Erreur de connexion à MySQL

```bash
# Vérifier que MySQL tourne
systemctl status mysql

# Tester la connexion
mysql -u portail_user -p -e "SELECT 1"
```

### Page blanche

```bash
# Vérifier PHP-FPM
systemctl status php8.2-fpm

# Vérifier les logs PHP
tail -50 /var/log/php8.2-fpm.log
```

---

## 13. Sécurité supplémentaire

### 13.1 Fail2ban (protection contre les attaques brute-force)

```bash
apt install -y fail2ban
systemctl enable fail2ban
systemctl start fail2ban
```

### 13.2 Créer un utilisateur non-root (recommandé)

```bash
# Créer l'utilisateur
adduser deployer

# Ajouter aux groupes nécessaires
usermod -aG www-data deployer
usermod -aG sudo deployer

# Configurer SSH pour cet utilisateur
mkdir -p /home/deployer/.ssh
cp /root/.ssh/authorized_keys /home/deployer/.ssh/
chown -R deployer:deployer /home/deployer/.ssh
chmod 700 /home/deployer/.ssh
chmod 600 /home/deployer/.ssh/authorized_keys
```

---

## Résumé rapide

| Action | Commande |
|--------|----------|
| **Connexion VPS** | `ssh root@72.62.190.57` |
| **Déployer** | `cd /var/www/portail_rh && ./deploy.sh` |
| **Logs Laravel** | `tail -f storage/logs/laravel.log` |
| **Redémarrer Nginx** | `systemctl restart nginx` |
| **Redémarrer PHP** | `systemctl restart php8.2-fpm` |
| **Vider cache** | `php artisan cache:clear` |
| **Mode maintenance** | `php artisan down` / `php artisan up` |
| **Backup DB** | `mysqldump -u portail_user -p portail_rh > backup.sql` |

---

## Checklist du premier déploiement

- [ ] Mise à jour du système (`apt update && apt upgrade`)
- [ ] Installation PHP 8.2 + extensions
- [ ] Installation Nginx
- [ ] Installation MySQL
- [ ] Installation Composer
- [ ] Installation Node.js 20
- [ ] Création base de données `portail_rh`
- [ ] Création utilisateur MySQL `portail_user`
- [ ] Clonage du repository
- [ ] Configuration .env
- [ ] Installation dépendances Composer
- [ ] Installation dépendances NPM
- [ ] Build des assets (npm run build)
- [ ] Génération de la clé Laravel
- [ ] Migration de la base de données
- [ ] Configuration Nginx
- [ ] Installation certificat SSL
- [ ] Configuration du pare-feu
- [ ] Test de l'application
- [ ] Configuration des sauvegardes automatiques

---

*Guide créé le 20 janvier 2026 pour Portail RH*
