# AGENTS.md — Projet Gestion d’une Bibliothèque Universitaire

## Contexte du projet

Ce projet est un site web simple de gestion d’une bibliothèque universitaire.

Il s’agit d’un projet scolaire demandé par le professeur de SQL Server. Le niveau attendu est celui d’un étudiant : l’application doit être claire, simple, fonctionnelle et respecter strictement l’énoncé donné.

Le client fictif est le responsable d’une petite bibliothèque universitaire qui gérait auparavant les livres et les emprunts sur papier. L’objectif est de lui fournir une petite application web permettant de gérer les livres, les étudiants, les emprunts, les retours, les recherches et quelques statistiques simples.

## Technologies imposées

Le projet doit utiliser uniquement les technologies suivantes :

- Backend : PHP
- Base de données : Microsoft SQL Server
- Connexion à la base : PDO avec le driver `pdo_sqlsrv`
- Frontend : HTML, CSS, Bootstrap
- Icônes : Bootstrap Icons
- Serveur local : WampServer
- Base locale actuelle : SQL Server Express

Ne pas introduire de framework PHP comme Laravel, Symfony ou autre.

Ne pas introduire de framework JavaScript.

Ne pas transformer le projet en application SPA.

Ne pas utiliser MySQL, MariaDB, SQLite ou PostgreSQL.

## Contraintes importantes du professeur

Le professeur a fourni des fichiers Bootstrap et Bootstrap Icons. Ces fichiers doivent être utilisés localement dans le projet.

Le professeur a aussi fourni un template HTML. Ce template doit être réutilisé comme base visuelle de l’application.

Il ne faut pas refaire le design de zéro.

Il ne faut pas modifier profondément les couleurs, le style visuel, la structure graphique ou l’identité du template fourni.

Le travail attendu consiste à adapter le template au projet de bibliothèque : titres, menus, contenus, tableaux, formulaires, boutons, statistiques, etc.

## Objectif fonctionnel

L’application doit permettre de gérer :

- Les livres
- Les étudiants
- Les emprunts
- Les retours
- Les recherches
- Les statistiques simples

L’application doit contenir quelques formulaires, des listes de données et des boutons simples : ajouter, modifier, supprimer.

## Périmètre strict de l’énoncé

L’application doit rester simple et respecter l’énoncé.

Ne pas ajouter de fonctionnalités avancées non demandées, sauf si elles sont nécessaires au bon fonctionnement de base.

Ne pas ajouter de système d’authentification/admin sauf demande explicite.

Ne pas ajouter de rôles, permissions, historique, logs, notifications, export PDF, API REST ou dashboard trop complexe.

Ne pas complexifier inutilement la base de données.

## Base de données

La base de données existe déjà dans SQL Server.

Nom actuel de la base :

- `GestionBibliothequedemo`

La connexion PHP est définie dans :

- `config/database.php`

Le fichier `database.php` contient une classe `Database` avec une méthode `getConnection()` qui retourne une connexion PDO SQL Server.

Ne pas casser cette connexion.

Ne pas remplacer PDO par une autre méthode.

Ne pas hardcoder une nouvelle connexion dans chaque page. Toutes les pages doivent utiliser la connexion centralisée existante.

## Tables existantes

Les tables principales sont :

- `categories`
- `livres`
- `etudiants`
- `emprunts`

### Table `categories`

Elle sert à classer les livres par catégorie.

Champs principaux :

- `id`
- `nom`

Relation :

- Une catégorie peut avoir plusieurs livres.
- Un livre appartient à une seule catégorie.

### Table `livres`

Elle sert à enregistrer les livres.

Champs principaux :

- `id`
- `titre`
- `auteur`
- `categorie_id`
- `annee`
- `quantite_disponible`

Relation :

- Un livre appartient à une catégorie.
- Un livre peut être lié à plusieurs emprunts dans le temps.

Règles :

- La quantité disponible ne doit jamais être négative.
- Un livre ne doit pas être supprimé s’il est déjà lié à un ou plusieurs emprunts.
- Pour récupérer les livres d’un auteur, utiliser le champ `auteur` directement dans la table `livres`.

### Table `etudiants`

Elle sert à enregistrer les étudiants qui empruntent des livres.

Champs principaux :

- `id`
- `nom`
- `prenom`
- `numero_etudiant`
- `filiere`
- `contact`

Règles :

- Le numéro étudiant doit rester unique.
- Un étudiant ne doit pas être supprimé s’il est déjà lié à un ou plusieurs emprunts.

### Table `emprunts`

Elle sert à enregistrer les emprunts.

Champs principaux :

- `id`
- `livre_id`
- `etudiant_id`
- `date_emprunt`
- `date_retour_prevue`
- `est_retourne`

Relations :

- Un emprunt concerne un livre.
- Un emprunt concerne un étudiant.

Règles :

- La date prévue de retour doit être supérieure ou égale à la date d’emprunt.
- Un emprunt non retourné a `est_retourne = 0`.
- Un emprunt retourné a `est_retourne = 1`.
- Les retards sont calculés avec les emprunts non retournés dont `date_retour_prevue` est inférieure à la date du jour.

## Règles de suppression

Respecter les relations SQL Server.

Ne pas supprimer automatiquement les données liées.

Règles attendues :

- Une catégorie ne peut pas être supprimée si elle contient encore des livres.
- Un livre ne peut pas être supprimé s’il est lié à un ou plusieurs emprunts.
- Un étudiant ne peut pas être supprimé s’il est lié à un ou plusieurs emprunts.

Dans l’interface, si une suppression échoue à cause d’une relation, afficher un message simple et compréhensible, par exemple :

- Impossible de supprimer cette catégorie car elle contient des livres.
- Impossible de supprimer ce livre car il est lié à un emprunt.
- Impossible de supprimer cet étudiant car il est lié à un emprunt.

## Fonctionnalités à réaliser

### Tableau de bord

Créer une page d’accueil simple affichant quelques informations générales :

- Nombre total de livres
- Nombre total d’étudiants
- Nombre total d’emprunts
- Nombre d’emprunts en cours
- Nombre de retards

Le tableau de bord doit rester simple et utiliser le template fourni.

### Gestion des livres

Prévoir les actions suivantes :

- Afficher la liste complète des livres
- Ajouter un livre
- Modifier un livre
- Supprimer un livre
- Rechercher un livre

Pour chaque livre, gérer :

- Titre
- Auteur
- Catégorie
- Année
- Quantité disponible

La liste des livres doit afficher aussi le nom de la catégorie via une jointure avec `categories`.

La recherche peut porter sur :

- Le titre
- L’auteur
- La catégorie

### Gestion des catégories

Même si l’énoncé parle surtout de la catégorie du livre, prévoir une gestion simple des catégories pour que les formulaires de livres puissent proposer une liste correcte.

Actions simples :

- Liste des catégories
- Ajout d’une catégorie
- Modification d’une catégorie
- Suppression d’une catégorie si elle n’a pas de livres liés

### Gestion des étudiants

Prévoir les actions suivantes :

- Afficher la liste des étudiants
- Ajouter un étudiant
- Modifier un étudiant
- Supprimer un étudiant

Pour chaque étudiant, gérer :

- Nom
- Prénom
- Numéro étudiant
- Filière
- Téléphone ou email dans le champ `contact`

### Gestion des emprunts

Prévoir les actions suivantes :

- Enregistrer un emprunt
- Afficher la liste des emprunts
- Voir les emprunts en cours
- Marquer un emprunt comme retourné

Pour chaque emprunt, gérer :

- Livre
- Étudiant
- Date d’emprunt
- Date prévue de retour
- Statut retourné ou non

Lors de l’enregistrement d’un emprunt :

- Vérifier que le livre a une quantité disponible supérieure à 0.
- Diminuer la quantité disponible du livre de 1.
- Créer l’emprunt avec `est_retourne = 0`.

Lors du retour d’un livre :

- Mettre `est_retourne = 1`.
- Augmenter la quantité disponible du livre de 1.
- Ne pas créer un nouvel emprunt pour un retour.
- Ne pas augmenter plusieurs fois la quantité si l’emprunt est déjà retourné.

### Retards

Prévoir une page ou une section permettant d’afficher les étudiants ayant des retards.

Un retard correspond à :

- `est_retourne = 0`
- `date_retour_prevue` inférieure à la date du jour

Afficher au minimum :

- Nom et prénom de l’étudiant
- Livre emprunté
- Date d’emprunt
- Date prévue de retour

### Statistiques

Prévoir une page de statistiques simples.

Statistiques attendues :

- Nombre de livres par catégorie
- Nombre total d’emprunts
- Livres les plus empruntés
- Étudiants qui empruntent le plus

Ces statistiques doivent être faites avec des requêtes SQL simples utilisant `COUNT`, `GROUP BY`, `ORDER BY` et des jointures.

## Structure du projet

Structure actuelle ou souhaitée :

- `config/`
  - Contient la connexion à la base de données.
- `src/`
  - Contient les fichiers fournis par le professeur.
  - Contient Bootstrap local.
  - Contient Bootstrap Icons local.
  - Contient le template HTML fourni.
- `includes/`
  - Contiendra les parties communes extraites du template : header, menu, footer, etc.
- `pages/`
  - Contiendra les pages principales de l’application.
- `index.php`
  - Page d’entrée du projet.

Structure cible recommandée :

- `config/database.php`
- `src/bootstrap-5.3.3-dist/`
- `src/bootstrap-icons/`
- `src/templates/`
- `includes/header.php`
- `includes/sidebar.php`
- `includes/footer.php`
- `pages/dashboard.php`
- `pages/livres/`
- `pages/categories/`
- `pages/etudiants/`
- `pages/emprunts/`
- `pages/statistiques/`

La structure peut être légèrement adaptée si le template du professeur impose une organisation différente, mais il faut garder un projet simple et lisible.

## Utilisation du template fourni

Avant de coder les pages, inspecter le template HTML fourni dans `src/templates`.

Identifier :

- Le layout général
- La barre de navigation
- Le menu latéral ou supérieur
- Les zones de contenu
- Les classes Bootstrap utilisées
- Les fichiers CSS et JS nécessaires
- Les icônes utilisées

Ensuite, découper proprement le template en fichiers réutilisables si nécessaire :

- Header
- Menu
- Footer
- Zone de contenu

Conserver le style d’origine.

Ne pas remplacer Bootstrap par du CSS personnalisé inutile.

Ne pas créer un autre design.

Adapter uniquement le contenu au projet bibliothèque.

## Bootstrap et assets

Utiliser les fichiers Bootstrap locaux fournis dans `src`.

Ne pas utiliser de CDN sauf si le professeur l’a explicitement demandé.

Ne pas modifier les fichiers originaux de Bootstrap.

Ne pas modifier les fichiers originaux Bootstrap Icons.

Si un style personnalisé est nécessaire, créer un fichier CSS séparé et léger, mais uniquement pour de petites corrections.

## Bonnes pratiques PHP attendues

Utiliser la connexion centralisée dans `config/database.php`.

Utiliser PDO avec requêtes préparées pour toutes les opérations avec données utilisateur.

Ne pas concaténer directement les valeurs utilisateur dans les requêtes SQL.

Organiser le code de manière simple, compréhensible et niveau étudiant.

Afficher des messages simples après ajout, modification ou suppression.

Valider les champs obligatoires côté serveur.

Garder les formulaires simples.

Gérer les erreurs SQL de manière propre, surtout pour les suppressions impossibles à cause des relations.

## Style de code attendu

Le code doit être clair, lisible et facile à expliquer au professeur.

Éviter les abstractions trop complexes.

Éviter les architectures trop avancées.

Ne pas utiliser de namespaces complexes, autoloaders Composer ou MVC complet sauf demande explicite.

Le projet peut rester en PHP procédural organisé, ou utiliser quelques fonctions simples, mais il doit être facile à comprendre.

## Navigation attendue

Le menu de l’application doit permettre d’accéder aux sections principales :

- Tableau de bord
- Livres
- Catégories
- Étudiants
- Emprunts
- Retards
- Statistiques

Les libellés doivent être en français.

## Requêtes importantes à prévoir

Prévoir les requêtes pour :

- Liste des livres avec leur catégorie
- Recherche de livres par titre, auteur ou catégorie
- Liste des étudiants
- Liste des emprunts avec livre et étudiant
- Emprunts non retournés
- Étudiants en retard
- Livres les plus empruntés
- Nombre de livres par catégorie
- Nombre total d’emprunts
- Étudiants qui empruntent le plus

## Ce qu’il ne faut pas faire

Ne pas changer la technologie imposée.

Ne pas utiliser MySQL.

Ne pas supprimer ou déplacer inutilement les fichiers fournis par le professeur.

Ne pas refaire le design du template.

Ne pas ajouter des fonctionnalités hors sujet.

Ne pas casser la connexion SQL Server existante.

Ne pas stocker les fichiers Bootstrap via CDN si les fichiers locaux existent.

Ne pas créer une architecture trop avancée.

Ne pas mélanger tout le code dans un seul fichier énorme.

Ne pas ignorer les relations entre tables.

Ne pas permettre la suppression de données liées sans contrôle.

Ne pas oublier de mettre à jour la quantité disponible lors d’un emprunt ou d’un retour.

## Priorité de développement

Ordre conseillé :

1. Vérifier la connexion SQL Server.
2. Inspecter le template fourni.
3. Brancher correctement Bootstrap et Bootstrap Icons locaux.
4. Créer les includes communs à partir du template.
5. Créer le tableau de bord.
6. Créer la gestion des catégories.
7. Créer la gestion des livres.
8. Créer la gestion des étudiants.
9. Créer la gestion des emprunts.
10. Créer la gestion des retours.
11. Créer la page des retards.
12. Créer la page des statistiques.
13. Vérifier toutes les suppressions.
14. Tester les formulaires et les listes.
15. Nettoyer le code et les messages.

## Validation finale attendue

Avant de considérer le projet terminé, vérifier :

- La page d’accueil s’ouvre sans erreur.
- La connexion SQL Server fonctionne.
- Les fichiers Bootstrap locaux sont utilisés.
- Le template du professeur est respecté.
- On peut ajouter, modifier, supprimer des catégories quand possible.
- On peut ajouter, modifier, supprimer des livres quand possible.
- On peut ajouter, modifier, supprimer des étudiants quand possible.
- On peut enregistrer un emprunt.
- La quantité disponible baisse après un emprunt.
- On ne peut pas emprunter un livre avec quantité disponible égale à 0.
- On peut marquer un emprunt comme retourné.
- La quantité disponible remonte après un retour.
- Les emprunts en cours s’affichent correctement.
- Les retards s’affichent correctement.
- Les statistiques s’affichent correctement.
- Les suppressions liées affichent des messages clairs.
- Le code reste simple et compréhensible pour un projet étudiant.

## Rappel important

Ce projet doit être fonctionnel, simple et fidèle à l’énoncé.

La priorité est de produire une application claire que le professeur peut lancer facilement avec WampServer et SQL Server, sans configuration compliquée.