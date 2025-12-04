# Horizon Sportif - Application de Gestion Touristique

![Statut du projet](https://img.shields.io/badge/Statut-Terminé-brightgreen)
[![HTML](https://img.shields.io/badge/HTML-%23E34F26.svg?logo=html5&logoColor=white)](#)
![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![Java](https://img.shields.io/badge/Java-ED8B00?logo=openjdk&logoColor=white)
![Base de données](https://img.shields.io/badge/Database-MySQL-orange)
![Base de données](https://img.shields.io/badge/Database-MariaDB-blue)

## Contexte du Projet

Ce projet a été réalisé dans le cadre d'un Projet Transversal visant à valider les compétences de développement et de gestion de base de données.
L'objectif est de fournir une application de gestion pour une agence de tourisme fictive, permettant la gestion des circuits, des étapes touristiques et des réservations clients.

## Fonctionnalités

Le site gère deux types d'utilisateurs distincts:

### Espace Client

- Visualisation des circuits touristiques disponibles.
- Consultation des détails d'un voyage (étapes, activitées, durée).
- Réservation de places pour un circuit.

### Espace Administrateur

- **Gestion des Circuits :** Création, modification et suppression de voyages.
- **Gestion des Étapes et Lieux :** Association d'activitées et villes aux circuits.
- Accès global à la base de données.

## Base de Données & Modélisation

La base de donnée est une partie centrale du projet. Elle a été conçus pour rattacher une grande quantité d'informations (villes, pays, étapes d'un circuit, les clients et leurs réservations) et les associer à une période (date, durée).

### Schémas

Les schémas de conception sont disponibles dans le dépôt:

- **MCD (Modèle Conceptuel de Données)** : Voir le fichier ModeleEntiteObjet.jpg
- **MPD (Modèle Physique de Données)** : Voir le fichier ModelePhysique.jpg

### Structure des données

La base de donnée s'articule principalement autour des tables suivantes :

- `Circuit_touristique` : Le voyage global (date, durée, prix, description).
- `etape` : Toute les étapes qui composent un circuit.
- `activitee` : L'activitée ratachée à chaque étape.
- `client`, `Ville`, `pays`, `reservation`, `type`.

## Outils

- **Langage :** HTML, PHP, CSS, Java
- **Framework :** Bootstrap
- **BDD :** MYSQL et MariaDB

## Installation

1.  **Cloner le dépôt :**

    ```bash
    git clone [https://github.com/Zengorax/Projet_transversal_epreuve_tourism]
    ```

2.  **Configuration de la Base de Données :**

    - Importer la structure dans votre base de donnée

    ```sql
    bdd.sql; -- Contient la structure de la BDD
    data.sql; -- Contient le jeu de donnée
    ```

3.  **Configurer votre connection PDO :**

    - Maintenant que la bdd est prête renommez le config-exemple.php présent dans /app en config.php et modifiez les entrées en fonction de votre base de donnée

    ```php
    define('DB_SERVER', 'host:port'); # Remplacer host:port par le nom de votre serveur et son port (par défaut 3306 pour mysql) ex : localhost:3306
    define('DB_USERNAME', 'user'); # Remplacer user par le nom d'utilisateur
    define('DB_PASSWORD', 'password'); # Remplacer password par le mot de passe
    define('DB_NAME', 'nomdb'); # Remplacer nomdb par le nom que vous avez donner à la db précédement créer ex : applivoyage
    ```

4.  **Placer le dossier app ou son contenus à la racine de votre serveur puis ouvrez l'index.php**

## 📂 Structure du Projet

```text
├── bdd.sql                 # Structure de la BDD
├── data.sql                # Jeu de données
├── requete.sql             # Requêtes SQL demandées
├── ModelePhysique.jpg      # Schémas MPD
├── ModeleEntiteObjet.jpg   # Schémas MCD
├── README.md
├── app/                    # La partie site web
└── app/.gitignore
```
