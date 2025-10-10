# Symfony 7.3
## Auteur : Mattéo Godart
## Installation / Configuration :

## Installation de l'exécutable « symfony »

[Installez l'exécutable « symfony »](https://symfony.com/download) qui contient le serveur Web local en lançant la commande suivante :

	wget https://get.symfony.com/cli/installer -O - | bash 

Modifiez ou créez le fichier « **.profile** » (à la racine de votre compte) afin qu'il contienne 	
	
	export PATH="$HOME/.symfony5/bin:$PATH"

Chargez les modifications du « **.profile** » 

	source ~/.profile
	
Vérifiez le bon fonctionnement de l'exécutable « **symfony** » 

	symfony self:version

Contrôlez la compatibilité du système avec la commande : 

	symfony check:requirements  --verbose

## Installation de Composer

Si ce n'est pas déjà fait, installez [Composer](http://cutrona/installation-configuration/composer/) 

Vérifiez que **Composer** fonctionne correctement : 

	composer about

Mettez à jour **Composer** : 

	composer self-update

## Lancement d'un projet Symfony

Vérifiez que vous êtes bien dans le répertoire « **/working/votre_login** » (ou n'importe quel répertoire de votre choix si vous êtes sur votre ordinateur personnel) 


Lancez la création d'un nouveau projet **Symfony** version « **7.3.*** » : 

	symfony --version 7.3 --webapp new symfony-contacts

Placez-vous le répertoire de l'application 

Dans le terminal, lancez le serveur Web local avec la commande suivante : 

	symfony serve

Suivez les instructions données dans la partie « Gestion du certificat du serveur Web de l'API dans le navigateur » du tutoriel « [Configuration CORS pour utiliser l'authentification de l'API avec React](http://cutrona/tutoriels/cors-api-react/#gestion-du-certificat-du-serveur-web-de-l-api-dans-le-navigateur) » 

Accédez à l'URL « https://127.0.0.1:8000 »

Constatez l'apparition de la Web Debug Toolbar

Observez les sorties texte du serveur Web local

Naviguez rapidement à travers les outils de la Web Debug Toolbar

Observez les sorties texte du serveur Web local

Terminez l'exécution de l'outil ligne de commande « **symfony** » avec « **CTRL+C** » 

Afin de fiabiliser votre méthode de développement, vous allez utiliser **Git** pour gérer le suivi des versions de l'application **Symfony**. 

## Configuration du dépôt local Git

Assurez-vous d'être dans le répertoire du projet `symfony-contacts`

Constatez que le dépôt **Git** local a été initialisé par l'outil « **symfony** » en ligne de commande (« Symfony CLI ») 

    git log

Excluez du suivi de **Git** le répertoire « **.idea** » de **PhpStorm**

    echo -e "\n/.idea/" >> .gitignore

    git add .gitignore

    git commit -m "Exclusion du répertoire .idea"

## Configuration du dépôt distant Git

Créez un nouveau projet « symfony-contacts » sur GitLab (pensez à décocher la case «Initialize repository with a README»)

Associez le dépôt local et le dépôt distant 

Poussez la branche local


