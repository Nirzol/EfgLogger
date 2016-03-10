<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntStructure
 *
 * @ORM\Table(name="ent_structure")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntStructure extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="structure_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $structureId;

    /**
     * @var integer
     *
     * @ORM\Column(name="structure_fatherid", type="integer", nullable=false)
     */
    private $structureFatherid = '-1';

    /**
     * @var string
     *
     * @ORM\Column(name="structure_type", type="string", length=45, nullable=false)
     */
    private $structureType;

    /**
     * @var string
     *
     * @ORM\Column(name="structure_code", type="string", length=45, nullable=false)
     */
    private $structureCode;

    /**
     * @var string
     *
     * @ORM\Column(name="structure_libelle", type="string", length=250, nullable=false)
     */
    private $structureLibelle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="structure_is_valid", type="boolean", nullable=false)
     */
    private $structureIsValid = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="structure_last_update", type="datetime", nullable=true)
     */
    private $structureLastUpdate;

    /**
     * Set structureId
     *
     * @param integer $structureId
     *
     * @return EntStructure
     */
    public function setStructureId($structureId)
    {
        $this->structureId = $structureId;

        return $this;
    }

    /**
     * Get structureId
     *
     * @return integer
     */
    public function getStructureId()
    {
        return $this->structureId;
    }

    /**
     * Set structureFatherid
     *
     * @param integer $structureFatherid
     *
     * @return EntStructure
     */
    public function setStructureFatherid($structureFatherid)
    {
        $this->structureFatherid = $structureFatherid;

        return $this;
    }

    /**
     * Get structureFatherid
     *
     * @return integer
     */
    public function getStructureFatherid()
    {
        return $this->structureFatherid;
    }

    /**
     * Set structureType
     *
     * @param string $structureType
     *
     * @return EntStructure
     */
    public function setStructureType($structureType)
    {
        $this->structureType = $structureType;

        return $this;
    }

    /**
     * Get structureType
     *
     * @return string
     */
    public function getStructureType()
    {
        return $this->structureType;
    }

    /**
     * Set structureCode
     *
     * @param string $structureCode
     *
     * @return EntStructure
     */
    public function setStructureCode($structureCode)
    {
        $this->structureCode = $structureCode;

        return $this;
    }

    /**
     * Get structureCode
     *
     * @return string
     */
    public function getStructureCode()
    {
        return $this->structureCode;
    }

    /**
     * Set structureLibelle
     *
     * @param string $structureLibelle
     *
     * @return EntStructure
     */
    public function setStructureLibelle($structureLibelle)
    {
        $this->structureLibelle = $structureLibelle;

        return $this;
    }

    /**
     * Get structureLibelle
     *
     * @return string
     */
    public function getStructureLibelle()
    {
        return $this->structureLibelle;
    }

    /**
     * Set structureIsValid
     *
     * @param boolean $structureIsValid
     *
     * @return EntStructure
     */
    public function setStructureIsValid($structureIsValid)
    {
        $this->structureIsValid = $structureIsValid;

        return $this;
    }

    /**
     * Get structureIsValid
     *
     * @return boolean
     */
    public function getStructureIsValid()
    {
        return $this->structureIsValid;
    }

    /**
     * Set structureLastUpdate
     *
     * @param \DateTime $structureLastUpdate
     *
     * @return EntStructure
     */
    public function setStructureLastUpdate($structureLastUpdate)
    {
        $this->structureLastUpdate = $structureLastUpdate;

        return $this;
    }

    /**
     * Get structureLastUpdate
     *
     * @return \DateTime
     */
    public function getStructureLastUpdate()
    {
        return $this->structureLastUpdate;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setStructureLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }
}
