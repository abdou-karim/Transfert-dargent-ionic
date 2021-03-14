# Transfert-dargent-ionic-back
Pour cloner le projet back taper la commande : git clone https://github.com/abdou-karim/Transfert-dargent-ionic.git
Vous attendez que le telechargement se termine.
Apres ouvrez le projet avec votre editeur preferé par exemple phpStorm ou Vscode .
Taper la commande : composer install pour mettre a jour les dependances .

Pour :
- creer la base de donnee taper la commande : php bin/console doctrine:database:create
- Ensuite faite la migration avec la commande : php bin/console make:migration 
- Finaliser la migration : php bin/console doctrine:schema:update --force .

Maintenant vous allez devoir reconfigurer le systeme d'authentification sinon vous ne pourrez pas vous connecter .
Pas de soucis rien de plus facile que ca vous allez seulement taper quelques commandes . Allons y !!!!
Pour commancer taper la commande : mkdir config/jwt
Nous allons ensuite générer la clé privé avec openssl: openssl genrsa -out config/jwt/private.pem -aes256 4096
La console va te demander de renseigner un pass phrase, c'est comme un mot de passe pour sécuriser ton token, moi je vais saisir Sidibe123 et confirmer le encore .
Il faut ensuite générer la clé public: openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
Saisi le même pass phrase que tout à l'heure et c'est bon.
l faut ensuite renseigner le passphrase dans le fichier .env.local .
Donc Creer un fichier .env.local dans la racine du projet et copiais y ceci :

###> lexik/jwt-authentication-bundle ###
JWT_PASSPHRASE=Sidibe123
###< lexik/jwt-authentication-bundle ###
Maintenant tout est ok vous pouvez lancer votre serveur : php bin/console server:run

Pour initialiser les donnees vous pouvez soit lancer les fixtures soit importer la base de donnee deja disponible sur la racine du projet .
1)
Initialiser les donnees avec fixtures :
Rien de plus simple taper la commande : php bin/console doctrine:fixtures:load .
2) Pour importer la base de donnee aller sur phpMyadmin choisir l'option importer clicquer sur parcourir et choisissez la base de donnee sur la racine du projet .
