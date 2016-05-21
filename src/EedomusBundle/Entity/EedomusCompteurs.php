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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return EedomusCompteurs
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set valeur
     *
     * @param string $valeur
     *
     * @return EedomusCompteurs
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return string
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return EedomusCompteurs
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set periph
     *
     * @param \EedomusBundle\Entity\EedomusPeriph $periph
     *
     * @return EedomusCompteurs
     */
    public function setPeriph(\EedomusBundle\Entity\EedomusPeriph $periph)
    {
        $this->periph = $periph;

        return $this;
    }

    /**
     * Get periph
     *
     * @return \EedomusBundle\Entity\EedomusPeriph
     */
    public function getPeriph()
    {
        return $this->periph;
    }
}