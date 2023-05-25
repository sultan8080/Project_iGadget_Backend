<h1 align="center">Welcome to iGadget API 👋</h1>

![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

<p>
  <img alt="Version" src="https://img.shields.io/badge/version-0.0.1-blue.svg?cacheSeconds=2592000" />
</p>

# Résumé
Il s’agit de créer une application type E-Commerce classique, avec des listes de produits, une recherche, des filtres, un détail de produit, gestion de panier, paiement et de commande, etc… Avec également une gestion du compte utilisateur, et une gestion administrative pour les comptes et une gestion commerciale pour les ajouts de produits.

- Page d’accueil vitrine. Mettant en avant les nouveaux produits, les produits populaires, etc…
- Un système de recherche simple pour afficher une liste de produits
- Un système de recherche avancée, avec choix de différents critères de recherche
- Page Liste de produits / résultat de la recherche, ayant un système de filtre dessus pour affiner la recherche déjà effectuée
- Page Détails d’un produit, ayant toutes les descriptions nécessaires au produit (nom, référence, prix, taxe, description, description détaillé, mesure, stock, ajout panier, type, tags, etc…)
- Page Panier pour voir le panier actuel (modification quantité, suppression produit, résumé du panier, valider panier)
- Page suivi de commande, permettant de voir l’état de la commande
- Page Contact, permettant de contacter les responsables derrière l’application.
- Page retour, permettant de contacter les responsables commerciaux pour faire une demande de retour de colis.
- Page historique des commandes
- Gestion de Compte :
    - Création de compte (avec envoi d’email de confirmation)
    - Modification de compte
    - Modification de mot de passe
    - Gestion de mot de passe oubliée
    - Suppression de compte
- Panel gestion Commercial
- Gestion des produits
- Gestion des tags, types, etc…
- Gestion des commandes et retour
- Tout un panel de fonctionnalités Admin

Optionnel :
- Connection Oauth2, avec au moins Google et Facebook
- Gérer le paiement via Stripe
- Stockage des fichiers (notamment les images d’articles) dans AWS ou GoogleCloud, Firebase 
- Exportation de facture en PDF
- Proposition d’auto-complétion pour les recherches 
- Notification en WebSocket


# Installation
Git clone HTTPS 
```sh
git clone https://github.com/INCUBATEUR-M2i-AFPA/SymfonySquad-backend.git
```

ou SSH
```sh
git clone git@github.com:INCUBATEUR-M2i-AFPA/SymfonySquad-backend.git
```

Aller dans le dossier
```sh
cd SymfonySquad-backend
```

Installer toute les dépences nécessaire
```sh
composer install
```

 Démarrer le serveur
```sh
symfony server:start
```

