# Transfert-dargent-ionic-back
Pour cloner le projet back taper la commande : git clone https://github.com/abdou-karim/Transfert-dargent-ionic.git
Vous attendez que le telechargement se termine.
Apres ouvrez le projet avec votre editeur preferé par exemple phpStorm ou Vscode .
Taper la commande : composer install pour mettre a jour les dependances .
Pour :
- creer la base de donnee taper la commande : php bin/console doctrine:database:create
- Ensuite faite la migration avec la commande : php bin/console make:migration 
- Finaliser la migration : php bin/console doctrine:schema:update --force .
Pour initialiser les donnees vous pouvez soit lancer les fixtures soit importer la base de donnee deja disponible sur la racine du projet .
1)
Initialiser les donnees avec fixtures :
Rien de plus simple taper la commande : php bin/console doctrine:fixtures:load .
Maintenant vous allez devoir reconfigurer le systeme d'authentification sinon vous ne pourrez pas vous connecter .
Pas de soucis rien de plus facile que ca vous allez seulement taper quelques commandes . Allons y !!!!
