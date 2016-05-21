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
              new EedomusBundle\EedomusBundle(),
            );
        }

5. Ajouter les routes du bundle à votre projet en ajoutant dans votre fichier app/config/routing.yml :

        EedomusBundle:
            resource: "@EedomusBundle/Resources/config/routing.yml"
            prefix:   /
            
## License
Thibautg16EedomusBundle is released under the Apache License 2.0. See the bundled [LICENSE](LICENSE) file for details.
