# Green Goodies - Site E-commerce

Green Goodies est un site e-commerce développé avec Symfony 7.3, permettant la gestion de produits, de panier d'achat, de commandes et d'utilisateurs.

## 📋 Description

Ce projet est une application web e-commerce complète avec :
- **Frontend** : Interface utilisateur avec Tailwind CSS et Stimulus
- **Backend** : API REST avec authentification JWT
- **Administration** : Interface d'administration avec EasyAdmin
- **Base de données** : PostgreSQL avec Doctrine ORM
- **Authentification** : Système de connexion et d'inscription
- **Gestion des commandes** : Panier d'achat et suivi des commandes

## 🛠️ Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- **PHP** >= 8.2 avec les extensions suivantes :
  - `ext-ctype`
  - `ext-iconv`
  - `ext-pdo_pgsql` (pour PostgreSQL)
- **Composer** >= 2.0
- **Node.js** >= 18.x et **npm**
- **PostgreSQL** >= 16
- **Symfony CLI** (optionnel mais recommandé)
- **Docker** et **Docker Compose** (optionnel, pour simplifier l'installation)

## 📦 Installation

### Étape 1 : Cloner le projet

```bash
git clone git@github.com:quentin-mace/green-goodies.git
cd green_goodies
```

### Étape 2 : Installer les dépendances PHP

```bash
composer install
```

### Étape 3 : Installer les dépendances JavaScript

```bash
npm install --force
```

### Étape 4 : Configuration de l'environnement

Copiez le fichier d'exemple de configuration :

```bash
cp .env.dev.sample .env
```

Puis éditez le fichier `.env` et configurez les variables suivantes :

```env
###> symfony/framework-bundle ###
APP_SECRET=566940b0236132a5c565d8ad5347cb0e
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
###< doctrine/doctrine-bundle ###
```

**Important** : Modifiez les identifiants de connexion à la base de données selon votre configuration PostgreSQL :
- `app` : nom d'utilisateur PostgreSQL
- `!ChangeMe!` : mot de passe PostgreSQL
- `app` : nom de la base de données
- `5432` : port PostgreSQL (par défaut)

### Étape 5 : Générer les clés JWT (pour l'authentification API)

Si vous souhaitez utiliser l'API avec authentification JWT, générez les clés nécessaires :

```bash
# Créer le dossier config/jwt s'il n'existe pas
mkdir -p config/jwt

# Générer les clés privée et publique
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

**Note** : Vous devrez entrer un mot de passe lors de la génération. Assurez-vous de le configurer dans le fichier `.env` avec la variable `JWT_PASSPHRASE` si vous en utilisez un.

### Étape 6 : Créer la base de données

Si vous utilisez Docker Compose (recommandé) :

```bash
make docker-up
```

Sinon, assurez-vous que PostgreSQL est démarré et créez la base de données :

```bash
# Avec Symfony CLI
symfony console doctrine:database:create --if-not-exists

# Ou avec le Makefile
make sf-dc
```

### Étape 7 : Exécuter les migrations

```bash
# Avec Symfony CLI
symfony console doctrine:migrations:migrate --no-interaction

# Ou avec le Makefile
make sf-dmm
```

### Étape 8 : Charger les données de test (fixtures)

```bash
# Avec Symfony CLI
symfony console doctrine:fixtures:load --no-interaction

# Ou avec le Makefile
make sf-fixtures
```

### Étape 9 : Compiler les assets

```bash
# En mode développement
npm run dev

# Ou en mode production
npm run build
```

### Étape 11 : Démarrer le serveur Symfony

```bash
# Avec Symfony CLI
symfony serve -d

# Ou avec le Makefile
make start
```

Le serveur sera accessible à l'adresse : `http://localhost:8000`

## 🚀 Lancement rapide

Si vous avez Docker et Docker Compose installés, vous pouvez utiliser la commande d'installation complète :

```bash
make first-install
```

Cette commande va :
1. Démarrer les conteneurs Docker
2. Installer les dépendances Composer
3. Installer les dépendances npm
4. Compiler les assets
5. Configurer les permissions
6. Créer la base de données
7. Exécuter les migrations
8. Démarrer le serveur Symfony
9. Ouvrir le projet dans le navigateur

## 🌐 Accès à l'application

Une fois le serveur démarré, vous pouvez accéder à :

- **Application principale** : http://localhost:8000
- **Interface d'administration** : http://localhost:8000/admin
- **API REST** : http://localhost:8000/api

## 🔐 Authentification

Les fixtures chargent des utilisateurs de test. Consultez le fichier `config/fixtures/users.yaml` pour connaître les identifiants de connexion.

## 🐛 Dépannage

### Problème de connexion à la base de données

Vérifiez que PostgreSQL est bien démarré et que les identifiants dans `.env` sont corrects :

```bash
# Vérifier la connexion PostgreSQL
psql -U app -d app -h 127.0.0.1
```

### Problème avec les assets

Si les assets ne se chargent pas correctement :

```bash
# Recompiler les assets
npm run build

# Vider le cache Symfony
make sf-cc
```
