# [PHP] - P7 Openclassrooms - Créez un web service exposant une API

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/a04d6e15461c4d67a4a9b8ebc9b79610)](https://www.codacy.com/manual/thomas-claireau/PHP-P7-Openclassrooms?utm_source=github.com&utm_medium=referral&utm_content=thomas-claireau/PHP-P7-Openclassrooms&utm_campaign=Badge_Grade)

[![Maintainability](https://api.codeclimate.com/v1/badges/b350fbd18550b9521cbe/maintainability)](https://codeclimate.com/github/thomas-claireau/PHP-P7-Openclassrooms/maintainability)

Démo du projet, [c'est par ici 👋](http://bilemo.thomas-claireau.fr)

## Installation du projet

Via Composer :

```text
composer create-project thomas-claireau/bilemo:dev-master
```

Dans le cas où vous téléchargez directement le projet (ou encore avec `git clone`), effectuez un `composer install` à la racine du projet.

Installez ensuite les dépendances front du projet (pour lancer l'interface d'api-platform). Placez-vous à la racine du projet :

```text
npm install
```

### Remarque

#### Accès base de données

Le projet est livré sur Packagist sans base de données. Cela signifie qu'il faut que vous ajoutiez votre configuration, dans le fichier `.env`, dans la partie `DATABASE_URL`.

#### Injection SQL et structure du projet

Pour obtenir une structure similaire à mon projet au niveau de la base de données, je vous joins aussi dans le dossier `~src/Migrations/` les versions de migrations que j'ai utilisées. Vous pouvez donc recréer la base de données en effectuant la commande suivante, à la racine du projet :

```text
php bin/console doctrine:migrations:migrate
```

Après avoir créer votre base de données, vous pouvez également injecter un jeu de données en effectuant la commande suivante :

```text
php bin/console doctrine:fixtures:load
```

### Lancer le projet

A la racine du projet :

-   Pour lancer le serveur de développement, effectuez un `npm run dev-server`.
-   Pour lancer le serveur de symfony, effectuez un `php bin/console server:run`.

### Authentification

A ce niveau la, vos requêtes vers l'api seront refusées car vous ne serez pas authentifié au sein du projet. Suivez donc les étapes suivantes :

#### 1. Générer les clés SSH pour le Json Web Token (JWT)

#### 2. Récupérez ou créez vous un compte

Dans les fixtures du projet (`src/DataFixtures`), ajoutez votre propre compte.

Vous pouvez aussi utiliser le compte suivant :

-   email : root@root.fr
-   password : root

#### 3. Générez un JWT

```text
curl -X POST -H "Content-Type: application/json" http://bilemo.thomas-claireau.fr/authentication_token -d "{\"email\":\"YOUR_EMAIL\",\"password\":\"YOUR_PASSWORD\"}"
```

Remplacez YOUR_EMAIL par votre email (par ex. root@root.fr) et YOUR_PASSWORD par votre mot de passe (par ex. root)

Vous devriez obtenir le résultat suivant :

```json
{
	"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1ODI4NzA2NzEsImV4cCI6MTU4Mjg3NDI3MSwicm9sZXMiOlsiUk9MRV9BRE1JTiJdLCJlbWFpbCI6InJvb3RAcm9vdC5mciJ9.J4lnq2gxrrKY5MB39AGvVYlM7ezYvTcgI-ITBdjxXNAu-5ePTqYdW6-SaJLyZCXdDeUXFi0An89oPVHIRgzdifLyav5CLxUnkX_aDQcxD4Gnh3pLJnOeRb7zBGN7XR8ZUG1raG6S84ZrIzdANCkz-xq24Z1F-ahPd30SxmgV0GNFh5bH7pzfgaJflhpi0KMWdL1dUJgK788UGJvVW7FYNcm9SsR3h3-wCd33bcJ1h60f4QQ-xxEMCZihfEhIvMmotcA1r"
}
```

#### 4. Utilisez le JWT pour effectuer des opérations

Récupérez le token généré pour commencer à utiliser l'API de Bilemo.

```text
curl -H "Authorization: Bearer {yourtoken}" {yourdomain}/api/{entrypoint}
```

Pour connaitre tous les entrypoints disponibles, allez voir la [démo du projet 👋](http://bilemo.thomas-claireau.fr)

## Contexte

BileMo est une entreprise offrant toute une sélection de téléphones mobiles haut de gamme.

Vous êtes en charge du développement de la vitrine de téléphones mobiles de l’entreprise BileMo. Le business modèle de BileMo n’est pas de vendre directement ses produits sur le site web, mais de fournir à toutes les plateformes qui le souhaitent l’accès au catalogue via une API (Application Programming Interface). Il s’agit donc de vente exclusivement en B2B (business to business).

Il va donc falloir que vous exposiez un certain nombre d’API pour que les applications des autres plateformes web puissent effectuer des opérations.

## Besoin client

Le premier client a enfin signé un contrat de partenariat avec BileMo ! C’est le branle-bas de combat pour répondre aux besoins de ce premier client qui va permettre de mettre en place l’ensemble des API et les éprouver tout de suite.

Après une réunion dense avec le client, il a été identifié un certain nombre d’informations. Il doit être possible de :

consulter la liste des produits BileMo ;
consulter les détails d’un produit BileMo ;
consulter la liste des utilisateurs inscrits liés à un client sur le site web ;
consulter le détail d’un utilisateur inscrit lié à un client ;
ajouter un nouvel utilisateur lié à un client ;
supprimer un utilisateur ajouté par un client.
Seuls les clients référencés peuvent accéder aux API. Les clients de l’API doivent être authentifiés via Oauth ou JWT.

Vous avez le choix de mettre en place un serveur Oauth et d’y faire appel (en utilisant le FOSOAuthServerBundle) ou d’utiliser Facebook, Google ou LinkedIn. Si vous décidez d’utiliser JWT, il vous faudra vérifier la validité du token ; l’usage d’une librairie est autorisée.

## Présentation des données

Le premier partenaire de BileMo est très exigeant : il requiert que vous exposiez vos données en suivant les règles des niveaux 1, 2 et 3 du modèle de Richardson. Il a demandé à ce que vous serviez les données en JSON. Si possible, le client souhaite que les réponses soient mises en cache afin d’optimiser les performances des requêtes en direction de l’API.

## ⌛ Projet en cours...
