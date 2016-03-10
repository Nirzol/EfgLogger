<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntVersion
 *
 * @ORM\Table(name="ent_version")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntVersion extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ent_version", type="string", length=64, unique=true, nullable=false)
     */
    protected $version;

    /**
     * @var string
     *
     * @ORM\Column(name="version_commentaire", type="text", nullable=true)
     */
    protected $versionCommentaire;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="version_date", type="datetime", nullable=false)
     */
    private $versionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="version_last_update", type="datetime", nullable=true)
     */
    private $versionLastUpdate;

    /**
     * Constructor
     */
    public function __construct($version = null)
    {
        if ($version != null) {
            $this->version = (string) $version;
        }
        $this->versionDate = new \DateTime();
    }

    /**
     * Get the version identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return EntVersion
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get getVersion
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set setVersionCommentaire
     *
     * @param string $aString
     *
     * @return EntVesrion
     */
    public function setVersionCommentaire($aString)
    {
        $this->versionCommentaire = $aString;

        return $this;
    }

    /**
     * Get getVersionCommentaire
     *
     * @return string
     */
    public function getVersionCommentaire()
    {
        return $this->versionCommentaire;
    }

    /**
     * Set setVersionDate
     *
     * @param \DateTime $aDtate
     *
     * @return EntVesrion
     */
    public function setVersionDate($aDtate)
    {
        $this->versionDate = $aDtate;

        return $this;
    }

    /**
     * Get getVersionDate
     *
     * @return \DateTime
     */
    public function getVersionDate()
    {
        return $this->versionDate;
    }

    /**
     * Get versionLastUpdate
     *
     * @return \DateTime
     */
    public function getVersionLastUpdate()
    {
        return $this->versionLastUpdate;
    }

    /**
     * Set versionLastUpdate
     *
     * @param \DateTime $versionLastUpdate
     *
     * @return EntVersion
     */
    public function setVersionLastUpdate($versionLastUpdate)
    {
        $this->versionLastUpdate = $versionLastUpdate;

        return $this;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setVersionLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }
}
