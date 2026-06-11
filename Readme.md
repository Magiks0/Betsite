# 🚀 Plateforme de Paris Sportifs Fictive
---

## ⚙️ Installation

### Prérequis
* PHP 8.2+ / Composer / Symfony CLI / MySQL ou PostgreSQL

### Étapes d'installation
1. **Cloner le projet** : `git clone <url>`
2. **Dépendances** : `composer install`
3. **Configuration** : Configurer `.env` avec `DATABASE_URL`.
4. **Base de données** :
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   php bin/console doctrine:fixtures:load
