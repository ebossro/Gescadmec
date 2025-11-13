# GESCADMEC - Système de Gestion Académique

##  Description

**GESCADMEC** est une application web complète de **gestion académique et administrative** conçue pour les établissements d'enseignement. Elle permet de centraliser et d'automatiser la gestion des étudiants, inscriptions, paiements et besoins académiques.

##  Fonctionnalités principales

###  Gestion des Étudiants
- Création et enregistrement des profils étudiants
- Suivi des informations personnelles (nom, sexe, date de naissance)
- Gestion des coordonnées de contact (téléphone, email)
- Consultation et modification des dossiers
- Suppression des profils avec cascade des données associées

###  Gestion des Inscriptions
- Inscription des étudiants à différents niveaux académiques
- Suivi des dates d'inscription et d'expiration
- Calcul automatique des **jours restants** avant expiration
- Statut d'inscription en temps réel
- Historique des inscriptions par étudiant

###  Gestion des Paiements
- Suivi du statut paiement (Soldé, Partiel, Impayé)
- Gestion du solde restant par étudiant
- Historique des transactions
- Visualisation du bilan financier par étudiant

###  Gestion des Besoins
- Signalement des besoins académiques
- Suivi et traitement des demandes d'étudiants

###  Tableau de Bord
- Vue d'ensemble des statistiques
- Métriques clés (nombre d'étudiants, paiements, etc.)
- Interface administrative centralisée

##  Stack Technique

### Backend
- **Framework** : Laravel 12.x
- **Langage** : PHP 8.2+
- **ORM** : Eloquent
- **Tests** : PHPUnit

### Frontend
- **Templating** : Blade (Laravel)
- **CSS Framework** : Bootstrap 5
- **Icons** : BoxIcons

### Base de Données
- Architecture relationnelle
- Migrations Laravel versionnées
- Seeders pour données de test

##  Structure du Projet

```
gescadmec/
├── app/
│   ├── Http/
│   │   └── Controllers/         
│   ├── Models/                  
│   │   ├── Etudiant.php
│   │   ├── Inscription.php
│   │   ├── Paiement.php
│   │   ├── Besoin.php
│   │   ├── Niveau.php
│   │   └── User.php
│   └── Providers/               
├── database/
│   ├── migrations/               
│   ├── seeders/                  
│   └── factories/                
├── resources/
│   ├── views/                    
│   │   ├── etudiants/
│   │   ├── paiements/
│   │   ├── besoins/
│   │   ├── layout/
│   │   └── components/
│   ├── css/                      
│   └── js/                       
├── routes/                       
├── config/                       
├── tests/                        
├── public/                       
└── storage/                      
```

##  Installation

### Prérequis
- **PHP** 8.2 ou supérieur
- **Composer** 2.x
- **Git**
- Une base de données (MySQL, PostgreSQL, SQLite, etc.)

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/ebossro/gescadmec.git
cd gescadmec
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer la base de données**
   - Éditer le fichier `.env` avec vos identifiants de base de données
   - Créer une base de données vide

7. **Exécuter les migrations**
```bash
php artisan migrate
```

8. **Charger les données initiales**
```bash
php artisan db:seed
```

##  Développement

### Serveur de développement Laravel
```bash
php artisan serve
```
L'application sera accessible à `http://127.0.0.1:8000`

### Exécuter les tests
```bash
php artisan test
```

## 📱 Pages principales

| Page | Route | Description |
|------|-------|-------------|
| Dashboard | `/admin` | Tableau de bord administrateur |
| Étudiants | `/etudiants` | Liste et gestion des étudiants |
| Créer étudiant | `/etudiants/create` | Formulaire d'inscription |
| Détails étudiant | `/etudiants/{id}` | Profil complet d'un étudiant |
| Paiements | `/paiements` | Suivi des paiements |
| Besoins | `/besoins` | Gestion des besoins académiques |

##  Modèles de données

### Étudiant
- nom_complet
- sexe
- date_naissance
- telephone
- email

### Inscription
- etudiant_id
- niveau_id
- date_debut
- date_fin
- statut_paiement
- solde_restant
- jours_restants 

### Paiement
- inscription_id
- montant
- date_paiement

### Niveau
- code (A1, A2, B1, B2, C1, C2)
- libelle

### Besoin
- etudiant_id
- description
- statut

## Authentification

L'application utilise le système d'authentification Laravel standard avec rôles administrateur.

## Auteur

**ebossro** - Gescadmec

## Contact & Support

Pour toute question ou problème, merci de créer une issue sur le repository.

