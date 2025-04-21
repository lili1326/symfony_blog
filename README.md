# Symfony Blog – Projet PHP avec Symfony

## Objectif du projet

Ce projet est un blog développé avec le framework **Symfony**, permettant aux utilisateurs de :

- Consulter des articles
- Créer, modifier et supprimer des publications (CRUD)
- Gérer l’authentification (connexion, inscription)

C'est un projet réalisé dans le cadre de ma formation **Développeur Web et Web Mobile (DWWM)**.

---

## Technologies utilisées

- PHP 8.x
- Symfony 6.x
- Twig (moteur de templates)
- Doctrine ORM
- MySQL / MariaDB
- **MySQL Workbench** (outil de gestion de base de données)
- Bootstrap 5 (interface)
- Composer
- Git / GitHub

---

## Installation et configuration

### 1. Cloner le dépôt

```bash
git clone https://github.com/lili1326/symfony_blog.git
cd symfony_blog
```

### 2. Installer les dépendances PHP avec Composer

```bash
composer install
```

### 3. Configurer la base de données

- Ouvre **MySQL Workbench**
- Crée une base de données (ex : `symfony_blog`)
- Récupère les informations de connexion (utilisateur, mot de passe)

Ensuite, crée un fichier `.env.local` :

```bash
cp .env .env.local
```

Et modifie cette ligne avec tes infos MySQL :

```
DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/symfony_blog"
```

### 4. Créer la base et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le serveur Symfony

```bash
symfony server:start
```

ou avec PHP natif :

```bash
php -S 127.0.0.1:8000 -t public
```

---

## Fonctionnalités

- Page d’accueil listant les derniers articles
- Lecture détaillée d’un article
- Création / modification / suppression d’un article via formulaire
- Interface d'administration (si activée)
- Système d’authentification utilisateur (si implémenté)

---

## Compétences mises en œuvre (DWWM)

| Bloc   | Compétence                                                   |
| ------ | ------------------------------------------------------------ |
| Bloc 2 | Créer une base de données relationnelle avec MySQL Workbench |
| Bloc 2 | Développer des composants métier côté serveur                |
| Bloc 2 | Accès aux données avec Doctrine (SQL)                        |
| Bloc 1 | Intégrer une interface avec Twig (HTML/CSS)                  |

---

## Auteur

Aurélie [Ton Nom ici]  
Projet réalisé dans le cadre du **titre professionnel DWWM**

---

## Licence

Projet open-source — réutilisable dans un cadre pédagogique.
