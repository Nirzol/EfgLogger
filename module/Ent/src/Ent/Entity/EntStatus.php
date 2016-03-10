<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntStatus
 *
 * @ORM\Table(name="ent_status")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntStatus extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="status_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $statusId;

    /**
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=250, nullable=false, unique=true)
     */
    private $statusName;

    /**
     * @var string
     *
     * @ORM\Column(name="status_libelle", type="string", length=250, nullable=true)
     */
    private $statusLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="status_description", type="text", nullable=true)
     */
    private $statusDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status_last_update", type="datetime", nullable=true)
     */
    private $statusLastUpdate;

    /**
     * Get statusId
     *
     * @return integer
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set statusName
     *
     * @param string $statusName
     *
     * @return EntStatus
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;

        return $this;
    }

    /**
     * Get statusName
     *
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusName;
    }

    /**
     * Set statusLibelle
     *
     * @param string $statusLibelle
     *
     * @return EntStatus
     */
    public function setStatusLibelle($statusLibelle)
    {
        $this->statusLibelle = $statusLibelle;

        return $this;
    }

    /**
     * Get statusLibelle
     *
     * @return string
     */
    public function getStatusLibelle()
    {
        return $this->statusLibelle;
    }

    /**
     * Set statusDescription
     *
     * @param string $statusDescription
     *
     * @return EntStatus
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;

        return $this;
    }

    /**
     * Get statusDescription
     *
     * @return string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * Set statusLastUpdate
     *
     * @param \DateTime $statusLastUpdate
     *
     * @return EntStatus
     */
    public function setStatusLastUpdate($statusLastUpdate)
    {
        $this->statusLastUpdate = $statusLastUpdate;

        return $this;
    }

    /**
     * Get statusLastUpdate
     *
     * @return \DateTime
     */
    public function getStatusLastUpdate()
    {
        return $this->statusLastUpdate;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setStatusLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }
}
