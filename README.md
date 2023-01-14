# Déploiement de votre application Symfony en local

Pour déployer une application Symfony en local, vous avez besoin de suivre les étapes suivantes :

1. Assurez-vous d'avoir les prérequis suivants installés sur votre ordinateur :

    - [PHP 7.1 ou version ultérieure](https://www.php.net/downloads.php)
    - [MySQL](https://www.mysql.com/downloads/) ou un autre serveur de base de données compatible avec Symfony, je recommande [PhpMyAdmin](https://www.phpmyadmin.net/downloads/)
    - Un serveur Web (par exemple Apache ou Nginx), je recommande [Xampp](https://www.apachefriends.org/fr/download.html).
    - [Composer](https://getcomposer.org/download/)




2. Téléchargez et installez Symfony en utilisant l'installateur Composer :

```console
composer create-project symfony/skeleton:"6.2.*" my_project_directory
cd my_project_directory
composer require webapp
```


3. Configurez votre base de données en modifiant les paramètres dans le fichier .env :


```console 
DATABASE_URL=mysql://utilisateur:mot_de_passe@127.0.0.1:3306/nom_de_la_base_de_données
```

4. Créez la base de données en exécutant la commande suivante :

```console 
php bin/console doctrine:database:create
```


5. Créez les tables en utilisant les entités de votre application, attention vous aurez besoin de [MakerBundle de Symfony](https://www.php.net/downloads.php) pour executer ces commandes :

````console
php bin/console make:migration
php bin/console doctrine:migrations:migrate
````

6. Démarrez le serveur Web interne de Symfony en exécutant la commande suivante :

```console
php bin/console server:run
```

Votre application Symfony est maintenant déployée et accessible à l'adresse http://localhost:8000.



