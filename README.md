# Thibautg16EedomusBundle

**//!\\ Attention : ce module est en cours de développement //!\\**

### Prérequis
- php => 5.5.9
- Symfony 3.*
- ObHighchartsBundle
- Thibautg16UtilisateurBundle
- Thibautg16SqueletteBundle

## Installation EedomusBundle
### Installation à l'aide de composer
1. Installer symfony si necessaire :
        composer create-project symfony/framework-standard-edition eedomus "2.8.*"

1. Ajouter ``thibautg16/eedomus-bundle`` comme dépendance de votre projet dans le fichier ``composer.json`` :

        {
          "require": {
            "thibautg16/eedomus-bundle": "dev-master"
          }
          "minimum-stability": "dev",
          "prefer-stable": true,
        }

3. Installer vos dépendances :

        php composer.phar update

4. Ajouter le Bundle dans votre kernel :

        <?php
        // app/AppKernel.php
        
        public function registerBundles(){
            $bundles = array(
              // ...
              new Thibautg16\SqueletteBundle\Thibautg16SqueletteBundle(),
              new Thibautg16\UtilisateurBundle\Thibautg16UtilisateurBundle(),
              new Ob\HighchartsBundle\ObHighchartsBundle(),
              new EedomusBundle\EedomusBundle(),
            );
        }

5. Ajouter les routes du bundle à votre projet en ajoutant dans votre fichier app/config/routing.yml :

        EedomusBundle:
            resource: "@EedomusBundle/Resources/config/routing.yml"
            prefix:   /
            
        Thibautg16UtilisateurBundle:
            resource: "@Thibautg16UtilisateurBundle/Resources/config/routing.yml"
            prefix:   /

        Thibautg16SqueletteBundle:
           resource: "@Thibautg16SqueletteBundle/Resources/config/routing.yml"
           prefix:   /

6. Update des entitees et creation / update BDD
        php bin/console doctrine:generate:entities EedomusBundle
        php bin/console doctrine:generate:entities Thibautg16UtilisateurBundle       
        php bin/console doctrine:schema:update --force
        
### Installation à l'aide du script install_epargne.sh
1. Télécharger le script 
        wget https://raw.githubusercontent.com/Thibautg16/EedomusBundle/master/src/install_eedomus.sh               

2. Exécuter le script en précisant le dossier d'installation
        bash install_eedomus.sh /srv/www/eedomus  
                     
## License
Thibautg16EedomusBundle is released under the Apache License 2.0. See the bundled [LICENSE](LICENSE) file for details.