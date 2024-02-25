<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Nextcloud extends BaseConfig
{
    /**
     * Connexion avec Nextcloud
     */
    public bool $nextcloudActive = false;

    /**
     * Informations de connexion
     */
    public string $nextcloudUrl = '';

    public string $nextcloudIdClient = '';

    public string $nextcloudSecret = '';

    public string $nextcloudRedirectUri = '';

    /**
     * Dossier de stockage des fichiers
     */
    public string $nextcloudFolder = 'Castopod';
}
