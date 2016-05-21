<?php
/**
 * src/EedomusBundle/Entity/EedomusPeriph.php
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
 * EedomusPeriph
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EedomusBundle\Entity\EedomusPeriphRepository")
 */
class EedomusPeriph
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
     * @var integer
     *
     * @ORM\Column(name="periph_id", type="integer")
     */
    private $periphId;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_periph_id", type="integer")
     */
    private $parentPeriphId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value_type", type="string", length=255)
     */
    private $valueType;

    /**
     * @var string
     *
     * @ORM\Column(name="value_unite", type="string", length=255, nullable=TRUE)
     */
    private $valueUnite;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="room_id", type="integer")
     */
    private $roomId;

    /**
     * @var string
     *
     * @ORM\Column(name="room_name", type="string", length=255)
     */
    private $roomName;

    /**
     * @var integer
     *
     * @ORM\Column(name="usage_id", type="integer")
     */
    private $usageId;

    /**
     * @var string
     *
     * @ORM\Column(name="usage_name", type="string", length=255)
     */
    private $usageName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update", type="datetime", nullable=TRUE)
     */
    private $lastUpdate;

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
     * Set periphId
     *
     * @param integer $periphId
     * @return EedomusPeriph
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
     * Set parentPeriphId
     *
     * @param integer $parentPeriphId
     * @return EedomusPeriph
     */
    public function setParentPeriphId($parentPeriphId)
    {
        $this->parentPeriphId = $parentPeriphId;

        return $this;
    }

    /**
     * Get parentPeriphId
     *
     * @return integer 
     */
    public function getParentPeriphId()
    {
        return $this->parentPeriphId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EedomusPeriph
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set valueType
     *
     * @param string $valueType
     * @return EedomusPeriph
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
     * Set valueUnite
     *
     * @param string $valueUnite
     * @return EedomusMesures
     */
    public function setValueUnite($valueUnite)
    {
        $this->valueUnite = $valueUnite;

        return $this;
    }

    /**
     * Get valueUnite
     *
     * @return string 
     */
    public function getValueUnite()
    {
        return $this->valueUnite;
    }

    /**
     * Set roomId
     *
     * @param integer $roomId
     * @return EedomusPeriph
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;

        return $this;
    }

    /**
     * Get roomId
     *
     * @return integer 
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Set roomName
     *
     * @param string $roomName
     * @return EedomusPeriph
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * Get roomName
     *
     * @return string 
     */
    public function getRoomName()
    {
        return $this->roomName;
    }

    /**
     * Set usageId
     *
     * @param integer $usageId
     * @return EedomusPeriph
     */
    public function setUsageId($usageId)
    {
        $this->usageId = $usageId;

        return $this;
    }

    /**
     * Get usageId
     *
     * @return integer 
     */
    public function getUsageId()
    {
        return $this->usageId;
    }

    /**
     * Set usageName
     *
     * @param string $usageName
     * @return EedomusPeriph
     */
    public function setUsageName($usageName)
    {
        $this->usageName = $usageName;

        return $this;
    }

    /**
     * Get usageName
     *
     * @return string 
     */
    public function getUsageName()
    {
        return $this->usageName;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return EedomusPeriph
     */
    public function setlastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getlastUpdate()
    {
        return $this->lastUpdate;
    }
    
    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return EedomusPeriph
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}
