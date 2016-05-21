<?php
/**
 * src/EedomusBundle/Scripts/configuration.php
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

//Authentification BDD
# IP du serveur de BDD
$host = "127.0.0.1";
# Utilisateur pour la connexion à la BDD
$utilisateurBDD = "userBDD";
# Mot de passe pour la connexion à la BDD
$mdpBDD = "mdpBDD";
# Nom de la BDD
$nomBDD = "nomBDD"

// Authentification APIEedomus
$api_user = 'apiEedomusUser';
$api_secret = 'apiEedomusMdp';

// Configuration compteur
$periphCompteur = array('Gaz_Cave' => array('type' => 'GAZ', 'id' => '98'), 
                        'Edf_Entree' => array('type' => 'EDF', 'id' => '69'));