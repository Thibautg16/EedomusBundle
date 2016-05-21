#!/bin/bash
# =============================================================================
#
# SCRIPT : install_eedomus.sh
# DESCRIPTION : deploiement semi-automatique du projet eedomus
# AUTEUR : Gillardeau Thibaut (aka Thibautg16)
# DATE : 21/05/2016
#
# VERSION 0.2
#
# 21/05/2016 - Creation script original - v0.1
# 21/05/2016 - Correction app/AppKernel.php - v0.2
#
# =============================================================================

# =============================================================================
# Déclaration et vérification des variables
# =============================================================================
if [ -z "$1" ]
then
	dossier="eedomus"
else
	dossier=$1
fi

# =============================================================================
# Script
# =============================================================================
composer create-project symfony/framework-standard-edition ${dossier} "3.*"
cd ${dossier}
sed -i '/"symfony\/symfony": "3.*",/a "thibautg16/eedomus-bundle": "dev-master",' composer.json
sed -i 's/.*"extra": {.*/"minimum-stability": "dev",\n&/' composer.json
sed -i 's/.*"extra": {.*/"prefer-stable": true,\n&/' composer.json
sed -i '/$bundles = \[/a new EedomusBundle\\EedomusBundle(),' app/AppKernel.php
sed -i '/new EedomusBundle\EedomusBundle(),/a new Ob\\HighchartsBundle\\ObHighchartsBundle(),' app/AppKernel.php
sed -i '/new EedomusBundle\EedomusBundle(),/a new Thibautg16\\SqueletteBundle\\Thibautg16SqueletteBundle(),' app/AppKernel.php
sed -i '/new EedomusBundle\EedomusBundle(),/a new Thibautg16\\UtilisateurBundle\\Thibautg16UtilisateurBundle(),' app/AppKernel.php
echo '
EedomusBundle:
    resource: "@EedomusBundle/Resources/config/routing.yml"
    prefix:   /

Thibautg16UtilisateurBundle:
   resource: "@Thibautg16UtilisateurBundle/Resources/config/routing.yml"
   prefix:   /

Thibautg16SqueletteBundle:
    resource: "@Thibautg16SqueletteBundle/Resources/config/routing.yml"
    prefix:   /
' >> app/config/routing.yml
composer update
php bin/console doctrine:generate:entities Thibautg16UtilisateurBundle
php bin/console doctrine:generate:entities EedomusBundle
php bin/console doctrine:schema:update --force
rm src/AppBundle/Controller/DefaultController.php
echo '# app/config/security.yml

security:
    encoders:
        Thibautg16\UtilisateurBundle\Entity\Utilisateur:
            algorithm:   sha512
            iterations: 1
            encode_as_base64: false

    providers:
        main:
            entity: { class: Thibautg16\UtilisateurBundle\Entity\Utilisateur, property:username }

    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false

        # On crée un pare-feu uniquement pour le formulaire
        main_login:
             # Cette expression régulière permet de prendre /login (mais pas /login_check !)
             pattern:   ^/login$
             # On autorise alors les anonymes sur ce pare-feu
             anonymous: true

        main:
            pattern:   ^/
            anonymous: false
            provider:  main
            form_login:
              login_path: login
              check_path: login_check
            logout:
              path:   logout
              target: /login

    role_hierarchy:
        ROLE_ADMIN: ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
' > app/config/security.yml 
rm -rf var/cache/* && rm -rf var/logs/* && chmod 777 var/cache/ && chmod 777 var/logs/