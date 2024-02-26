# Project Castopod - Jet FM

## Description

Ce projet est un fork de [Castopod](https://github.com/ad-aures/castopod), un logiciel de gestion de podcasts open-source développé par Ad Aures. Il a été créé pour le besoin spécifique de la radio Jet FM, une radio associative nantaise. 

Le but du projet est de moduler la plateforme Castopod pour répondre aux besoins de la radio Jet FM.

## Sommaire

- [Project Castopod - Jet FM](#project-castopod---jet-fm)
  - [Description](#description)
  - [Sommaire](#sommaire)
  - [Installation](#installation)
    - [1. Prérequis](#1-prérequis)
    - [2. Développement dans VS Code](#2-développement-dans-vs-code)
    - [3. Installation des dépendances](#3-installation-des-dépendances)
    - [4. Population de la base de données](#4-population-de-la-base-de-données)
    - [5. Lancement de l'application](#5-lancement-de-lapplication)
  - [Contribution](#contribution)

## Installation

### 1. Prérequis
1. Clonez le projet en lançant la commande suivante dans votre terminal :

```bash
git clone https://github.com/TanguyHue/castopod-Polytech.git
```

2. Créez un fichier `.env` à la racine du projet et ajoutez-y les variables d'environnement suivantes :

```bash
CI_ENVIRONMENT="development"
# If set to development, you must run `npm run dev` to start the static assets server
vite.environment="development"

# By default, this is set to true in the app config.
# For development, this must be set to false as it is
# on a local environment
app.forceGlobalSecureRequests=false

app.baseURL="http://localhost:8080/"

admin.gateway="cp-admin"
auth.gateway="cp-auth"

database.default.hostname="mariadb"
database.default.database="castopod"
database.default.username="castopod"
database.default.password="castopod"
database.default.DBPrefix="dev_"

analytics.salt="DEV_ANALYTICS_SALT"

cache.handler="redis"
cache.redis.host = "redis"

# You may not want to use redis as your cache handler
# Comment/remove the two lines above and uncomment
# the next line for file caching.
# -----------------------
#cache.handler="file"

######################################
# Media config
######################################
media.baseURL="http://localhost:8080/"

# S3
# Uncomment to store s3 objects using adobe/s3mock service
# -----------------------
#media.fileManager="s3"
#media.s3.bucket="castopod"
#media.s3.endpoint="http://172.31.0.6:9090/"
#media.s3.pathStyleEndpoint=true
```

### 2. Développement dans VS Code

Si vous utilisez Visual Studio Code, vous pouvez prendre avantage du dossier `.devcontainer/`. Il définit un environnement de développement contenant les outils nécessaires pour travailler sur le projet. Pour l'utiliser, suivez les étapes suivantes :

1. Installez l'extension [Remote - Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) dans Visual Studio Code.
2. Ouvrez le projet dans Visual Studio Code.
3. `Ctrl/Cmd + Shift + P` pour ouvrir la palette de commandes, puis tapez `Open in container` et appuyez sur `Entrée`.
> La fenêtre de Visual Studio Code va se recharger à l'intérieur du conteneur. La première fois que vous lancez cette commande, cela peut prendre un peu de temps car le conteneur doit être construit.

### 3. Installation des dépendances

1. Installation des dépendances PHP

```bash
composer install
```

> Les dépendances PHP ne sont incluses dans le dépôt Git. Vous devez donc les installer vous-même. Composer va aller voir dans les fichiers `composer.json` et `composer.lock` pour installer les dépendances nécessaires. Celles-ci sont installées dans le dossier `vendor/`.

2. Installation des dépendances JavaScript

```bash
npm install
```

> De la même manière, les dépendances JavaScript ne sont pas incluses dans le dépôt Git. Vous devez donc les installer vous-même. NPM va aller voir dans les fichiers `package.json` et `package.lock` pour installer les dépendances nécessaires. Celles-ci sont installées dans le dossier `node_modules/`.

3. Génération des assets statiques

```bash
# build all static assets at once
npm run build:static

# build specific assets
npm run build:icons
npm run build:svg
```

> Cette commande va générer les assets statiques nécessaires pour l'application. Cela inclut les icônes SVG, les fichiers CSS et JavaScript. Ces fichiers sont générés dans le dossier `public/assets/`.

### 4. Population de la base de données

1. Construiez la base de données avec la commande `migrate` : 

```bash	
php spark migrate -all
```

Vous aurez peut-être besoin d'annuler la migration : 

```bash
php spark migrate:rollback
```

2. Remplissez la base de données avec des données de test : 

```bash
php spark db:seed AppSeeder
```

Si besoin, vous pouvez également choisir d'ajouter les données séparément : 

```bash
# Populates all categories
php spark db:seed CategorySeeder

# Populates all Languages
php spark db:seed LanguageSeeder

# Populates all podcasts platforms
php spark db:seed PlatformSeeder

# Populates all Authentication data (roles definition…)
php spark db:seed AuthSeeder
```

### 5. Lancement de l'application

Le conteneur est maintenant prêt à être utilisé. Vous pouvez ouvrir un terminal dans Visual Studio Code et lancer les commandes suivantes :


```bash
npm run dev
```

Cela va lancer le serveur de développement et le serveur de fichiers statiques. Vous pouvez maintenant accéder à l'application en ouvrant votre navigateur à l'adresse `http://localhost:8080`.

Vous pouvez également accéder à l'interface phpmyadmin à l'adresse `http://localhost:`8888` avec les identifiants suivants :

- Utilisateur : `castopod`
- Mot de passe : `castopod`


## Contribution

Guidelines for contributing to your project.


