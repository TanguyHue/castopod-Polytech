#!/bin/bash
echo "Vérification de l'installation de Nextcloud"

if php occ status | grep -q "installed: false"; then
    echo "Nextcloud n'est pas encore installé."
    echo "Installation de Nextcloud"
    php occ maintenance:install --admin-user "castopod" --admin-pass "castopod"
    php occ user:setting castopod settings email "castopod@castopod.fr"
    echo "Ajout du domaine de confiance"
    php occ config:system:set trusted_domains 2 --value="172.31.0.2"
    php occ config:system:set trusted_domains 3 --value="172.31.0.4"
    echo "Installation terminée"
else
    echo "Nextcloud est installé."
    if php occ config:system:get trusted_domains | grep -q -E "172.31.0.2|172.31.0.4"; then
        echo "Les domaines de confiance sont déjà ajoutés"
    else
        echo "Ajout des domaines de confiance"
        # Ajout Castopod
        php occ config:system:set trusted_domains 2 --value="172.31.0.2"
        # Ajout MariaDB
        php occ config:system:set trusted_domains 3 --value="172.31.0.4"
    fi
fi
