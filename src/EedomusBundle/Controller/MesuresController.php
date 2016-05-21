<?php
/**
 * src/EedomusBundle/Controller/MesuresController.php
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

use EedomusBundle\Entity\EedomusMesures;
use Ob\HighchartsBundle\Highcharts\Highchart;

class MesuresController extends Controller{
	
        public function listeAction(){
               $repository = $this->getDoctrine()
                         ->getManager()
                         ->getRepository('EedomusBundle:EedomusMesures');

               $limit = 500;
               $liste = $repository->findBy(array(), array('date' => 'desc'), $limit, null);

               return $this->render('EedomusBundle:Mesures:liste.html.twig', array('liste' => $liste));
        }
        
        public function GraphAction(){
                //Initialisation des variables
                $em = $this->getDoctrine()->getManager();
                
                //Initialisation des variables
                date_default_timezone_set("Europe/Paris"); 
                $date = new \DateTime();
                $date = $date->sub(new \DateInterval('PT1H'));
                $fin = $date->format('Y-m-d H:i:s');
                $debut = $date->sub(new \DateInterval('P1D'));
                $debut = $date->format('Y-m-d H:i:s');               
                $periph_id = 25;
				
		//Initialisation des variables
                $lst_periph = array();
                $oPeriphs = $em
                        ->getRepository('EedomusBundle:EedomusPeriph')
                        ->findAll();
                
                foreach($oPeriphs as $Periph){
                        $lst_periph[] = array('id' => $Periph->getId(), 'name' => $Periph->getName());      
                }
                
                // Info sur le périphérique pour le graphique
                $oPeriph = $em
                        ->getRepository('EedomusBundle:EedomusPeriph')
                        ->find($periph_id);              

                $oValeurs = $em
                        ->getRepository('EedomusBundle:EedomusMesures')
                        ->myMesure($debut, $fin, $periph_id);

                //Mise en forme des valeurs
                $i=0;

                foreach($oValeurs as $valeur){
                        $data[$i]=floatval($valeur->getValue());
                        $x[$i]=$valeur->getDate()->format('d-m-y H:i:s');
                        $i++;
                }           

                $serie = array(
                        array("name" => $oPeriph->getName().' ('.$oPeriph->getValueUnite().')', "data" => $data)
                );

                //Generation du graphique
                $ob = new Highchart();
                $ob->chart->renderTo('chart');
                $ob->chart->type('areaspline');
                $ob->chart->zoomType('x');
                $ob->title->text($oPeriph->getName());
                //$ob->xAxis->title(array('text'  => "Date"));
                $ob->xAxis->categories($x);
                $ob->xAxis->type("datetime");
                $ob->xAxis->minTickInterval(10);                
                $ob->xAxis->labels(array('rotation' => -90));
                $ob->tooltip->useHTML(TRUE);
                $ob->tooltip->headerFormat('<small>&nbsp;&nbsp;{point.key}&nbsp;&nbsp;</small><table>');
                $ob->tooltip->pointFormat('<tr><td style="color: {series.color}">{series.name}: </td></tr> <tr><td style="text-align: right"><b>{point.y} </b></td></tr>');
                $ob->tooltip->footerFormat('</table>');
                $ob->yAxis->title(array('text'  => $oPeriph->getValueUnite()));
                $ob->plotOptions->series(array('marker' => array('enabled' => false)));
                $ob->series($serie);

                return $this->render('EedomusBundle:Mesures:graph.html.twig', array('ob' => $ob, 'lst_periph' => $lst_periph, 'periode' => 'Jour', 'idperiph' => 14));
        }	

        public function AjaxGraphAction(){
                //Initialisation des variables
                $em = $this->getDoctrine()->getManager();
                
                //Récupération des variables $_POST
		$request = Request::createFromGlobals();
		$periode = $request->request->get('periode', 'Jour');
                $periph_id = $request->request->get('periph_id', '14');
				
		//Initialisation des variables
                date_default_timezone_set("Europe/Paris"); 
                $date = new \DateTime();
                $date = $date->sub(new \DateInterval('PT1H'));
                $fin = $date->format('Y-m-d H:i:s');

                if($periode == 'Heure'){
                        $debut = $date->sub(new \DateInterval('PT1H'));
                        $minTickInterval = 1;
                }
                elseif($periode == 'Jour'){
                        $debut = $date->sub(new \DateInterval('P1D'));
                        $minTickInterval = 10;
                }
                elseif($periode == 'Semaine'){
                        $debut = $date->sub(new \DateInterval('P7D'));
                        $minTickInterval = 50;
                }
                elseif($periode == 'Mois'){
                        $debut = $date->sub(new \DateInterval('P1M'));
                        $minTickInterval = 100;
                }
                
                // Info sur le périphérique pour le graphique
                $oPeriph = $em
                        ->getRepository('EedomusBundle:EedomusPeriph')
                        ->find($periph_id);    
                                       
                $oValeurs = $em
                        ->getRepository('EedomusBundle:EedomusMesures')
                        ->myMesure($debut->format('Y-m-d H:i:s'), $fin, $periph_id);

                //Mise en forme des valeurs                
                $i=0;

                foreach($oValeurs as $valeur){
                        $data[$i]=floatval($valeur->getValue());
                        $x[$i]=$valeur->getDate()->format('d-m-y H:i:s');
                        $i++;
                }         
        
                $serie = array(
                        array("name" => $oPeriph->getName().' ('.$oPeriph->getValueUnite().')', "data" => $data)
                );

                //Generation du graphique
                $ob = new Highchart();
                $ob->chart->renderTo('chart');
                $ob->chart->type('areaspline');
                $ob->chart->zoomType('x');
                $ob->title->text($oPeriph->getName());
                $ob->xAxis->title(array('text'  => "Date"));
                $ob->xAxis->categories($x);
                $ob->xAxis->type("datetime");
                $ob->xAxis->minTickInterval($i/20);                
                $ob->xAxis->labels(array('rotation' => -90));
                $ob->tooltip->useHTML(TRUE);
                $ob->tooltip->headerFormat('<small>&nbsp;&nbsp;{point.key}&nbsp;&nbsp;</small><table>');
                $ob->tooltip->pointFormat('<tr><td style="color: {series.color}">{series.name}: </td></tr> <tr><td style="text-align: right"><b>{point.y} </b></td></tr>');
                $ob->tooltip->footerFormat('</table>');
                $ob->yAxis->title(array('text'  => $oPeriph->getValueUnite()));
                $ob->plotOptions->series(array('marker' => array('enabled' => false)));
                $ob->series($serie);

                return $this->render('EedomusBundle:Mesures:graph_ajax.html.twig', array('ob' => $ob));
        }		
}

