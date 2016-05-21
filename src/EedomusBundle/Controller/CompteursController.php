<?php
/**
 * src/EedomusBundle/Controller/CompteursController.php
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

namespace EedomusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use EedomusBundle\Entity\EedomusCompteurs;
use Ob\HighchartsBundle\Highcharts\Highchart;

class CompteursController extends Controller{
	
        public function listeAction($type){
               $repository = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('EedomusBundle:EedomusCompteurs');

               $limit = 500;
               $liste = $repository->findBy(array('type' => $type), array('date' => 'desc'), $limit, null);

               return $this->render('EedomusBundle:Compteurs:liste.html.twig', array('liste' => $liste));
        }
}