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

<br>

# Créer un administrateur pour le back-office de l'application web.

Pour cette étape vous pouvez choisir de créer simplement un User avec le rôle admin directement dans [PhpMyAdmin](https://www.phpmyadmin.net/downloads/).

Mais je vais vous donner les étapes pour le faire directement via le terminal.

1. Ouvrez votre terminal et accédez au répertoire d'installation de MySQL, généralement situé dans C:\xampp\mysql\bin si vous utilisez [Xampp](https://www.apachefriends.org/fr/download.html)

2. Connectez-vous à MySQL en utilisant vos informations de connexion (nom d'utilisateur et mot de passe) :

 ```console
 mysql -u username -p
 ```

3. Lorsque vous êtes invité à entrer votre mot de passe, tapez-le et appuyez sur entrée.Si il n'y a pas de mot de passe appuyez sur entrée simplement.

4. Si vous êtes connecté avec succès, vous devriez voir un prompt MySQL qui ressemble à ceci : mysql>.
   Ou un message vous indiquant que vous êtes bien connecté comme ceci :

 ```console
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 44
Server version: 10.4.27-MariaDB mariadb.org binary distribution

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]>
   ```

5. Sélectionnez la base de données à laquelle vous souhaitez accéder en utilisant la commande USE :

```console
USE nom_de_la_base_de_données;
```

6. Créez un utilisateur avec le rôle admin en utilisant la commande INSERT INTO

```console
INSERT INTO user (username, password, roles) VALUES ('admin', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', '["ROLE_ADMIN"]');
```
