<?php
/**
 * src/EedomusBundle/Scripts/ApiEedomus.php
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

class  ApiEedomus {

    // Attributs
    protected $api_user;
    protected $api_secret;
    protected $api_url = 'api.eedomus.com';
    protected $api_protocole = 'https';
    
    public function __construct($api_user, $api_secret){
        $this->api_user = $api_user;
        $this->api_secret = $api_secret;
        
        // On fais un test de connexion à l'api Eedomus
        $result = file_get_contents($this->api_protocole.'://'.$this->api_url.'/get?action=auth.test&api_user='.$this->api_user.'&api_secret='.$this->api_secret);
        
        // on controle le résultat
        if (strpos($result, '"success": 1') == false){
            echo "Une erreur est survenue: [".$result."]";
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function getPeripheriqueListe(){
        // On récupére la liste des périphériques
        $json = file_get_contents($this->api_protocole.'://'.$this->api_url.'/get?action=periph.list&api_user='.$this->api_user.'&api_secret='.$this->api_secret);
        
        // On parse le retour JSON pour pouvoir l'exploiter
       return json_decode(utf8_encode($json));
    }
    
    public function getHistoriquePeripherique($idPeripherique, $start_date, $end_date){
        if(!$idPeripherique){
            throw new Exception('Le périphérique n\'est pas défini', E_ERROR);
        }        
        if(!$start_date){
            throw new Exception('La date de début n\'est pas défini', E_ERROR);
        }
         if(!$end_date){
            throw new Exception('La date de fin n\'est pas défini', E_ERROR);
        }

        // On récupére l'historique du périphérique
        $json = file_get_contents($this->api_protocole.'://'.$this->api_url.'/get?action=periph.history&periph_id='.$idPeripherique.'&start_date='.$start_date.'&end_date='.$end_date.'&api_user='.$this->api_user.'&api_secret='.$this->api_secret);   

        // On parse le retour JSON pour pouvoir l'exploiter
       return json_decode(utf8_encode($json));
    }
}
?>