<?php
/**
 * src/EedomusBundle/Entity/EedomusMesures.php
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
 * EedomusMesures
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EedomusBundle\Entity\EedomusMesuresRepository")
 */
class EedomusMesures
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
     * @ORM\ManyToOne(targetEntity="EedomusBundle\Entity\EedomusPeriph")
     * @ORM\JoinColumn(nullable=false)

     */
    private $periph;

    /**
     * @var string
     *
     * @ORM\Column(name="value_type", type="string", length=255)
     */
    private $valueType;
   
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


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
     * Set valueType
     *
     * @param string $valueType
     * @return EedomusMesures
     */
    public function setValueType($valueType)
    {
        $this->valueType = $valueType;

        return $this;
    }

    /**
     * Get valueType
     *
     * @return string 
     */
    public function getValueType()
    {
        return $this->valueType;
    }
           
    /**
     * Set value
     *
     * @param string $value
     * @return EedomusMesures
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return EedomusMesures
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
     * Set periphId
     *
     * @param integer $periphId
     * @return EedomusMesures
     */
    public function setPeriphId($periphId)
    {
        $this->periphId = $periphId;

        return $this;
    }

    /**
     * Get periphId
     *
     * @return integer 
     */
    public function getPeriphId()
    {
        return $this->periphId;
    }

    /**
     * Set periph
     *
     * @param \EedomusBundle\Entity\EedomusPeriph $periph
     * @return EedomusMesures
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
