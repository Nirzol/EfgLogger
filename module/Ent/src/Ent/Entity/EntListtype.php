<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

/**
 * EntListtype
 *
 * @ORM\Table(name="ent_listtype")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntListtype extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="listtype_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @MaxDepth(1)
     * @Groups({"listtype"})
     */
    private $listtypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="listtype_name", type="string", length=250, nullable=false, unique=true)
     * @MaxDepth(1)
     * @Groups({"listtype"})
     */
    private $listtypeName;

    /**
     * @var string
     *
     * @ORM\Column(name="listtype_libelle", type="string", length=250, nullable=true)
     * @MaxDepth(1)
     * @Groups({"listtype"})
     */
    private $listtypeLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="listtype_description", type="text", nullable=true)
     * @MaxDepth(1)
     * @Groups({"listtype"})
     */
    private $listtypeDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="listtype_last_update", type="datetime", nullable=true)
     * @MaxDepth(1)
     * @Groups({"listtype"})
     */
    private $listtypeLastUpdate;

    /**
     * Get listtypeId
     *
     * @return integer
     */
    public function getListtypeId()
    {
        return $this->listtypeId;
    }

    /**
     * Set listtypeId
     *
     * @param int $id
     *
     * @return EntListtype
     */
    public function setListtypeId($id)
    {
        $this->listtypeId = $id;
        return $this;
    }

    /**
     * Set listtypeName
     *
     * @param string $listtypeName
     *
     * @return EntListtype
     */
    public function setListtypeName($listtypeName)
    {
        $this->listtypeName = $listtypeName;

        return $this;
    }

    /**
     * Get listtypeName
     *
     * @return string
     */
    public function getListtypeName()
    {
        return $this->listtypeName;
    }

    /**
     * Set listtypeLibelle
     *
     * @param string $listtypeLibelle
     *
     * @return EntListtype
     */
    public function setListtypeLibelle($listtypeLibelle)
    {
        $this->listtypeLibelle = $listtypeLibelle;

        return $this;
    }

    /**
     * Get listtypeLibelle
     *
     * @return string
     */
    public function getListtypeLibelle()
    {
        return $this->listtypeLibelle;
    }

    /**
     * Set listtypeDescription
     *
     * @param string $listtypeDescription
     *
     * @return EntListtype
     */
    public function setListtypeDescription($listtypeDescription)
    {
        $this->listtypeDescription = $listtypeDescription;

        return $this;
    }

    /**
     * Get listtypeDescription
     *
     * @return string
     */
    public function getListtypeDescription()
    {
        return $this->listtypeDescription;
    }

    /**
     * Set listtypeLastUpdate
     *
     * @param \DateTime $listtypeLastUpdate
     *
     * @return EntListtype
     */
    public function setListtypeLastUpdate($listtypeLastUpdate)
    {
        $this->listtypeLastUpdate = $listtypeLastUpdate;

        return $this;
    }

    /**
     * Get listtypeLastUpdate
     *
     * @return \DateTime
     */
    public function getListtypeLastUpdate()
    {
        return $this->listtypeLastUpdate;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setListtypeLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
//        if($this->getCreatedAt() == null)
//        {
//            $this->setCreatedAt(date('Y-m-d H:i:s'));
//        }
    }
}
