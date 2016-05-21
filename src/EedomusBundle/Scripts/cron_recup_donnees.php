<?php
/**
 * src/EedomusBundle/Scripts/cron_recup_donnees.php
 *
 * Copyright 2016 GILLARDEAU Thibaut (aka Thibautg16)
 *
 * Authors :
 *  - Gillardeau Thibaut (aka Thibautg16)
 *
 * Licensed under the Apache License, Version 2.0 (the "License"). 
 * You may not use this file except in compliance with the License. 
 * A copy of the License is located at :
 * 
 * http://www.apache.org/licenses/LICENSE-2.0.txt 
 * 
 * or in the "license" file accompanying this file. This file is distributed 
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either 
 * express or implied. See the License for the specific language governing 
 * permissions and limitations under the License. 
 */ 
 
// Api Eedomus
include('ApiEedomus.php');

// Configuration
include('configuration.php');

// Connection au serveur MYSQL
$dns = 'mysql:host='.$host.';dbname='.$nomBDD;
$connection = new PDO( $dns, $utilisateurBDD, $mdpBDD, array (PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

// Initialisation des valeurs pour la récupération de l'historique
$requete = $connection->prepare('SELECT EedomusMaj FROM maj');
$requete->execute();
$donnees = $requete->fetch();
$start_date = urlencode($donnees['EedomusMaj']);
echo "\nStart Date : ".$start_date.' ';

$end_date = new DateTime();
$end_date->add(new DateInterval('PT1H'));
$end_date = $end_date->format('Y-m-d H:i:s');
$end_date_url = urlencode($end_date);
echo 'End Date : '.$end_date." \n";

// Creation de l'objet
$ApiEedomus = new ApiEedomus($api_user, $api_secret);
$periph = $ApiEedomus->getPeripheriqueListe();

// Pour chaque périphérique, on récupére l'historique des valeurs
foreach($periph->body as $p){
        // Recuperation des informations nécessaires pour la suite
        $periph_id = $p->periph_id;
        $value_type = utf8_decode($p->value_type);
        $periph_name = $p->name;
        $i=0;

        // On regarde si le périphérique est déjà dans la base, sinon on l'ajoute
        $requete = $connection->prepare('SELECT id, last_update FROM EedomusPeriph WHERE periph_id = :periph_id');
        $requete->execute(array('periph_id'  => $periph_id));
        $donnees = $requete->fetch();

        if($donnees === FALSE){
                $insert = $connection->prepare('INSERT INTO EedomusPeriph VALUES(NULL, :periph_id, :parent_periph_id, :name, :value_type, :value_unite, :room_id, :room_name, :usage_id, :usage_name, :creation_date, :last_update)');
                $insert->execute(array(
                                            'periph_id'        => $periph_id,
                                            'parent_periph_id' => $p->parent_periph_id,
                                            'name'             => $p->name,
                                            'value_type'       => $p->value_type,
                                            'value_unite'      => NULL,
                                            'room_id'          => $p->room_id,
                                            'room_name'        => $p->room_name,
                                            'usage_id'         => $p->usage_id,
                                            'usage_name'       => $p->usage_name,
                                            'creation_date'    => $p->creation_date,
                                            'last_update'      => '2000-01-01 00:00:00',
                                        ));
                // On récupére l'id de ce nouveau phériphérique
                $periph = $connection->lastinsertid();
                // On défini arbitrairement la date de la derniére valeur enregistrée pour ce périphérique
                $lastUpdate = '2000-01-01 00:00:00';
        }
        else{
                // On récupére l'id de ce phériphérique
                $periph = $donnees['id'];
                // On récupére la date de la derniére valeur enregistrée pour ce périphérique +1 seconde
                // sinon on récupére la précédente valeur
                $lastUpdate = new DateTime($donnees['last_update']);
                $lastUpdate->add(new DateInterval('PT1S'));
                $lastUpdate = $lastUpdate->format('Y-m-d H:i:s');
        }


        $historique = $ApiEedomus->getHistoriquePeripherique($periph_id, urlencode($lastUpdate), $end_date_url);
        $periph_name = str_replace(' ', '_', ucwords(strtolower(iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', trim($periph_name)))));


        if(!empty($historique->body->history)){
                // On inverse le tableau pour avoir les valeurs des plus anciennes aux plus récentes
                $reversed = array_reverse($historique->body->history);

                // Pour chaque valeur, on l'ajoute dans la base de données
                foreach($reversed as $v){                        
                        /********* DEBUT CONSO ELEC & GAZ *********/
                        if(array_key_exists($periph_name, $periphCompteur)){
                                // On récupére la derniére valeur du compteur
                                $requete = $connection->prepare('SELECT id, valeur, date FROM EedomusCompteurs WHERE periph_id = :periph_id ORDER BY date DESC LIMIT 1');
                                $requete->execute(array('periph_id'  => $periph));
                                $donnees = $requete->fetch();

                                // On récupére la derniére mesure
                                $requete = $connection->prepare('SELECT id, value, date FROM EedomusMesures WHERE periph_id = :periph_id ORDER BY date DESC LIMIT 1');
                                $requete->execute(array('periph_id'  => $periph));
                                $LastMesure = $requete->fetch();
                                                                
                                // Calcul différence entre la précédentre mesure et cette mesure
                                $datePreMesure  = new DateTime($LastMesure['date']);
                                $dateMesure     = new DateTime($v[1]);
                                $intMesure      = $datePreMesure->diff($dateMesure);
                                $intervalMesure = $intMesure->format('%s') + ($intMesure->format('%i')*60) + ($intMesure->format('%h')*60*60);

                                // Calcul de la mesure et nouvelle valeur du compteur
                                $Mesure = (($LastMesure['value'])*($intervalMesure/3600));   
                                $compteur = $donnees['valeur'] + $Mesure;
                                
                                echo "Compteur ".$periphCompteur[$periph_name]['type']." | ".$periph." | ".$LastMesure['date']." | Valeur : ".$Mesure." | NewCompteur : ".$compteur."\n";                                

                                $insert = $connection->prepare('INSERT INTO EedomusCompteurs VALUES(NULL, :date, :valeur, :type, :periph_id)');
                                $success = $insert->execute(array(
                                                                'date'      => $LastMesure['date'],
                                                                'valeur'    => $compteur,
                                                                'type'      => $periphCompteur[$periph_name]['type'],
                                                                'periph_id' => $periph,
                                ));
                        }                        
                                               
                        /********* DEBUT ENREGISTREMENT BDD *********/
                        $insert = $connection->prepare('INSERT INTO EedomusMesures VALUES(NULL, :periph_id, :value_type, :value, :date)');
                        $i++;
                        $success = $insert->execute(array(
                                                'periph_id'  => $periph,
                                                'value_type' => $value_type,
                                                'value'      => $v[0],
                                                'date'       => $v[1],
                                                ));
                       /********* FIN ENREGISTREMENT BDD *********/
                }
                //On update le periph avec la date/heure de la derniére maj
                $update = $connection->prepare('UPDATE EedomusPeriph SET last_update = :lastUpdate WHERE periph_id = :periph_id');
                $success_up = $update->execute(array('lastUpdate' => $v[1], 'periph_id' => $periph_id));
                echo $periph_name.' / '.$periph_id.' : nb update => '.$i." date derniere : ".$v[1]." valeur : ".$v[0]."\n";
        }
        else{
                echo $periph_name.' / '.$periph_id." : nb update => 0\n";
        }
        sleep(3);
}
?>