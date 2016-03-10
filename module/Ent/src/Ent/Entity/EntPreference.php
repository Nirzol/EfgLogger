<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntPreference
 *
 * @ORM\Table(name="ent_preference", indexes={@ORM\Index(name="fk_pref_user_id", columns={"fk_pref_user_id"}), @ORM\Index(name="fk_pref_service_id", columns={"fk_pref_service_id"}), @ORM\Index(name="fk_pref_status_id", columns={"fk_pref_status_id"}), @ORM\Index(name="fk_pref_profile_id", columns={"fk_pref_profile_id"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntPreference extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="pref_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $prefId;

    /**
     * @var string
     *
     * @ORM\Column(name="pref_attribute", type="text", nullable=false)
     */
    private $prefAttribute;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pref_last_update", type="datetime", nullable=true)
     */
    private $prefLastUpdate;

    /**
     * @var \Ent\Entity\EntUser
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_pref_user_id", referencedColumnName="user_id", onDelete="CASCADE")
     * })
     */
    private $fkPrefUser;

    /**
     * @var \Ent\Entity\EntService
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntService")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_pref_service_id", referencedColumnName="service_id", onDelete="CASCADE" )
     * })
     */
    private $fkPrefService;

    /**
     * @var \Ent\Entity\EntStatus
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_pref_status_id", referencedColumnName="status_id")
     * })
     */
    private $fkPrefStatus;

    /**
     * @var \Ent\Entity\EntProfile
     *
     * @ORM\ManyToOne(targetEntity="Ent\Entity\EntProfile")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_pref_profile_id", referencedColumnName="profile_id", onDelete="CASCADE")
     * })
     */
    private $fkPrefProfile;

    /**
     * Get prefId
     *
     * @return integer
     */
    public function getPrefId()
    {
        return $this->prefId;
    }

    /**
     * Set prefAttribute
     *
     * @param string $prefAttribute
     *
     * @return EntPreference
     */
    public function setPrefAttribute($prefAttribute)
    {
        $this->prefAttribute = $prefAttribute;

        return $this;
    }

    /**
     * Get prefAttribute
     *
     * @return string
     */
    public function getPrefAttribute()
    {
        return $this->prefAttribute;
    }

    /**
     * Set prefLastUpdate
     *
     * @param \DateTime $prefLastUpdate
     *
     * @return EntPreference
     */
    public function setPrefLastUpdate($prefLastUpdate)
    {
        $this->prefLastUpdate = $prefLastUpdate;

        return $this;
    }

    /**
     * Get prefLastUpdate
     *
     * @return \DateTime
     */
    public function getPrefLastUpdate()
    {
        return $this->prefLastUpdate;
    }

    /**
     * Set fkPrefUser
     *
     * @param \Ent\Entity\EntUser $fkPrefUser
     *
     * @return EntPreference
     */
    public function setFkPrefUser(\Ent\Entity\EntUser $fkPrefUser = null)
    {
        $this->fkPrefUser = $fkPrefUser;

        return $this;
    }

    /**
     * Get fkPrefUser
     *
     * @return \Ent\Entity\EntUser
     */
    public function getFkPrefUser()
    {
        return $this->fkPrefUser;
    }

    /**
     * Set fkPrefService
     *
     * @param \Ent\Entity\EntService $fkPrefService
     *
     * @return EntPreference
     */
    public function setFkPrefService(\Ent\Entity\EntService $fkPrefService = null)
    {
        $this->fkPrefService = $fkPrefService;

        return $this;
    }

    /**
     * Get fkPrefService
     *
     * @return \Ent\Entity\EntService
     */
    public function getFkPrefService()
    {
        return $this->fkPrefService;
    }

    /**
     * Set fkPrefStatus
     *
     * @param \Ent\Entity\EntStatus $fkPrefStatus
     *
     * @return EntPreference
     */
    public function setFkPrefStatus(\Ent\Entity\EntStatus $fkPrefStatus = null)
    {
        $this->fkPrefStatus = $fkPrefStatus;

        return $this;
    }

    /**
     * Get fkPrefStatus
     *
     * @return \Ent\Entity\EntStatus
     */
    public function getFkPrefStatus()
    {
        return $this->fkPrefStatus;
    }

    /**
     * Set fkPrefProfile
     *
     * @param \Ent\Entity\EntProfile $fkPrefProfile
     *
     * @return EntPreference
     */
    public function setFkPrefProfile(\Ent\Entity\EntProfile $fkPrefProfile = null)
    {
        $this->fkPrefProfile = $fkPrefProfile;

        return $this;
    }

    /**
     * Get fkPrefProfile
     *
     * @return \Ent\Entity\EntProfile
     */
    public function getFkPrefProfile()
    {
        return $this->fkPrefProfile;
    }

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setPrefLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }
}
