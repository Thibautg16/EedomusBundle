<?php
/**
 * src/EedomusBundle/Entity/EedomusCompteurs.php
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

namespace EedomusBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EedomusCompteurs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EedomusBundle\Entity\EedomusCompteursRepository")
 */
class EedomusCompteurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;    

    /**
     * @var string
     *
     * @ORM\Column(name="valeur", type="string", length=255)
     */
    private $valeur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;    

    /**
     * @ORM\ManyToOne(targetEntity="EedomusBundle\Entity\EedomusPeriph")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $periph;
}