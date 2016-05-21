<?php
/**
 * src/EedomusBundle/Controller/DashboardController.php
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

class DashboardController extends Controller{
	
        public function dashboardAction(){
               // Initialisation des variables
               $em = $this->getDoctrine()->getManager();
               date_default_timezone_set("Europe/Paris"); 
               $lstCompteurs = [['type' => 'EDF', 'id' => '69'], 
                                ['type' => 'GAZ', 'id' => '98']];
               $nbTypeMesure = count($lstCompteurs);
               
               // On récupére / prépare les infos de chaque type de compteur
               for($i = 0; $i < $nbTypeMesure; $i++){
                       // Recupération des informations du compteur
                       $oCompteur[$lstCompteurs[$i]['type']] = $em
                                ->getRepository('EedomusBundle:EedomusCompteurs')
                                ->findOneBy(array('type' => $lstCompteurs[$i]['type']), array('date' => 'desc'), 1, null);                       
                       
                       /********* DEBUT GRAPH COMPTEUR *********/
                       // Initialisation variable
                       $date = new \DateTime();
                       $fin = $date->format('Y-m-d H:i:s');
                       $debut = $date->sub(new \DateInterval('P1D'));
                       $debut = $date->format('Y-m-d H:i:s');  

                        // Info sur le périphérique pour le graphique
                        $oPeriph = $em
                                ->getRepository('EedomusBundle:EedomusPeriph')
                                ->find($lstCompteurs[$i]['id']);      
                        
                        $oValeurs = $em
                                ->getRepository('EedomusBundle:EedomusMesures')
                                ->myMesure($debut, $fin, $lstCompteurs[$i]['id']);     

                        //Mise en forme des valeurs
                        $j=0;$data=NULL;$x=NULL;

                        foreach($oValeurs as $valeur){
                                $data[$j]=floatval($valeur->getValue());
                                $x[$j]=$valeur->getDate()->format('d-m-y H:i:s');
                                $j++;
                        }           

                        $serie = array(
                                array("name" => $oPeriph->getName().' ('.$oPeriph->getValueUnite().')', "data" => $data)
                        );               

                        // Generation du graphique                       
                        $obCompteur[$lstCompteurs[$i]['type']] = new Highchart();
                        $obCompteur[$lstCompteurs[$i]['type']]->chart->renderTo('chart'.$lstCompteurs[$i]['type']);
                        $obCompteur[$lstCompteurs[$i]['type']]->chart->type('areaspline');
                        $obCompteur[$lstCompteurs[$i]['type']]->chart->zoomType('x');
                        $obCompteur[$lstCompteurs[$i]['type']]->title->text($oPeriph->getName());
                        $obCompteur[$lstCompteurs[$i]['type']]->xAxis->categories($x);
                        $obCompteur[$lstCompteurs[$i]['type']]->xAxis->type("datetime");
                        $obCompteur[$lstCompteurs[$i]['type']]->xAxis->minTickInterval($j/20);                
                        $obCompteur[$lstCompteurs[$i]['type']]->xAxis->labels(array('rotation' => -90));
                        $obCompteur[$lstCompteurs[$i]['type']]->tooltip->useHTML(TRUE);
                        $obCompteur[$lstCompteurs[$i]['type']]->tooltip->headerFormat('<small>&nbsp;&nbsp;{point.key}&nbsp;&nbsp;</small><table>');
                        $obCompteur[$lstCompteurs[$i]['type']]->tooltip->pointFormat('<tr><td style="color: {series.color}">{series.name}: </td></tr> <tr><td style="text-align: right"><b>{point.y} </b></td></tr>');
                        $obCompteur[$lstCompteurs[$i]['type']]->tooltip->footerFormat('</table>');
                        $obCompteur[$lstCompteurs[$i]['type']]->yAxis->title(array('text'  => $oPeriph->getValueUnite()));
                        $obCompteur[$lstCompteurs[$i]['type']]->plotOptions->series(array('marker' => array('enabled' => false)));
                        $obCompteur[$lstCompteurs[$i]['type']]->series($serie);                                                                            
                        /********* FIN GRAPH COMPTEUR *********/                    
               }
               
               return $this->render('EedomusBundle:Dashboard:dashboard.html.twig', array('oCompteur' => $oCompteur, 'obCompteur' => $obCompteur));
        }	
}