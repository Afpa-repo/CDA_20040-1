![](public/img/lego.jpg)


# Description du projet

Création d'un site e-commerce en local en utilisant le framework Symfony 4.4.8. Ce projet contient plusieurs fonctionnalitées :

- Affichage liste des produits
- Recherche produits par Catégories / Prix
- Panier avec l'Ajout/Supression, gestion des quantités
- Inscription
- Connexion / Déconnexion
- Sauvegarde du panier
- Recherche autocomplete
- Création d'une facture en PDF
- Envois de la facture par mail lors de la validation du panier
- Envois mail 'mot de passe oublié'


#Pré-requis

- Composer
- Maildev
- Serveur local
- PHP (toutes les versions exceptés v 4.4.0, pour savoir votre version exécuter la commande ```PHP -v ``` dans votre terminal" )

#Installation

Après avoir installer composer et cloner le projet :

- Ouvrir votre terminal à la racine de votre projet et éxecuter la commande suivante ```composer install ```

Si votre serveur local est bien configuré, vous devriez voir un template du projet juste avec les navs et le carroussel.

(Ne pas oublier le chemin complet pour la page d'accueil : /Public/index.php)


#Démarrage

Pour démarrer le projet final (comprenant la création de la base de données ainsi que les produits) voici les différentes étapes :

- Vérifier dans le fichier '.env' que la ligne "DATABASE_URL=mysql://root@127.0.0.1:3306/lego?serverVersion=5.7" correspond à la configuration de votre serveur local.
    Par exemple si votre serveur MySQL est ouvert sur le port 3308 ce ne sera plus 'root@127.0.0.1:3306' mais 'root@127.0.0.1:3308'.

- Toujours dans votre terminal à la racine du projet faite la commande ``` php bin/console doctrine:database:create' ```

- Ensuite faite : ```  php bin/console doctrine:migrations:migrate ``` 

- Vérifier que votre base de donnée comporte la table 'lego' et importer le fichier 'public/SQL/products.sql'


#Fabriqué avec

- Bootstrap - Framework CSS (front-end)
- Dompdf - Bundle Symfony (PDF generator)
- Maildev - Serveur STMP local (envoi mail)
- Bloodhound & Typeahead (Autocompletion)

#Présentation rapide

![](public/img/presentation.gif)

#Auteurs

- Valentin : https://github.com/ValEttori
- Logan : https://github.com/Logan-55
- Paul : https://github.com/Paulo60650
- Mathieu : https://github.com/Menthealeau
