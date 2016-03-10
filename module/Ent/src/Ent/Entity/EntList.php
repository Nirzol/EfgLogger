<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntList
 *
 * @ORM\Table(name="ent_list")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntList extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="list_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $listId;

    /**
     * @var \Ent\Entity\EntListtype
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntListtype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_list_type_id", referencedColumnName="listtype_id")
     * })
     */
    private $fkListType;

    /**
     * @var string
     *
     * @ORM\Column(name="list_libelle", type="string", length=250, nullable=false)
     */
    private $listLibelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="list_last_update", type="datetime", nullable=true)
     */
    private $listLastUpdate;

    /**
     * Set listId
     *
     * @param integer $listId
     *
     * @return EntList
     */
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }

    /**
     * Get listId
     *
     * @return integer
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set fkListType
     *
     * @param \Ent\Entity\EntListtype $fkListType
     *
     * @return EntList
     */
    public function setFkListType(\Ent\Entity\EntListtype $fkListType = null)
    {
        $this->fkListType = $fkListType;

        return $this;
    }

    /**
     * Get fkListType
     *
     * @return \Ent\Entity\EntListtype
     */
    public function getFkListType()
    {
        return $this->fkListType;
    }

    /**
     * Set listLibelle
     *
     * @param string $listLibelle
     *
     * @return EntList
     */
    public function setListLibelle($listLibelle)
    {
        $this->listLibelle = $listLibelle;

        return $this;
    }

    /**
     * Get listLibelle
     *
     * @return string
     */
    public function getListLibelle()
    {
        return $this->listLibelle;
    }

    /**
     * Set listLastUpdate
     *
     * @param \DateTime $listLastUpdate
     *
     * @return EntList
     */
    public function setListLastUpdate($listLastUpdate)
    {
        $this->listLastUpdate = $listLastUpdate;

        return $this;
    }

    /**
     * Get listLastUpdate
     *
     * @return \DateTime
     */
    public function getListLastUpdate()
    {
        return $this->listLastUpdate;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setListLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }
}
