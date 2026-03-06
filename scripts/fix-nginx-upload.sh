#!/bin/bash
# Fix nginx 413 Request Entity Too Large
# Augmente la limite d'upload à 20MB pour les bulletins de paie PDF
# Usage : bash scripts/fix-nginx-upload.sh

set -e

NGINX_CONF=$(grep -rl "portail-rh\|portail_rh" /etc/nginx/sites-available/ 2>/dev/null | head -1)

if [ -z "$NGINX_CONF" ]; then
    # Essai sur le fichier default
    NGINX_CONF="/etc/nginx/sites-available/default"
fi

echo "Fichier nginx détecté : $NGINX_CONF"

# Ajouter client_max_body_size si pas déjà présent
if grep -q "client_max_body_size" "$NGINX_CONF"; then
    # Remplacer la valeur existante
    sed -i 's/client_max_body_size .*/client_max_body_size 20M;/' "$NGINX_CONF"
    echo "✅ client_max_body_size mis à jour → 20M"
else
    # Ajouter après la ligne server_name
    sed -i '/server_name/a\    client_max_body_size 20M;' "$NGINX_CONF"
    echo "✅ client_max_body_size 20M ajouté"
fi

# Vérifier la config nginx
nginx -t && systemctl reload nginx
echo "✅ Nginx rechargé — uploads jusqu'à 20MB maintenant autorisés"
