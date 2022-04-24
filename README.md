# SITE VITRINE COMELEON
### Site réalisé et developpé avec le Framework Symfony

## Fonctionnalités actuelles
- Consultation des différents avis laissés par les utilisateurs (constitués d'un nom, d'un titre et d'un commentaire)
- Ajout d'un avis
- Système de login
- Possibilité de consulter les différentes prestations disponibles
- Possibilité de commander des prestations, elles sont alors ajoutés dans un panier (Nécessite d'être connecté)
- Page de présentation de l'actvité
- Barre de navigation permettant de facilement naviguer sur le site

## Installer les requirements
- composer install
- composer update
- `composer require orm`
- `composer require security`
- `composer require symfony/form`
- `composer require validator`

## Récupérer la base de données
- `symfony console doctrine:database:create`
- `symfony console make:migration`
- `symfony console doctrine:migrations:migrate`
