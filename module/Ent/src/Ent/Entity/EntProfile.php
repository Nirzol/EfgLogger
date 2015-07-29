<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntProfile
 *
 * @ORM\Table(name="ent_profile")
 * @ORM\Entity
 */
class EntProfile extends Ent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="profile_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $profileId;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_ldap", type="string", length=250, nullable=false)
     */
    private $profileLdap;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_name", type="string", length=250, nullable=false)
     */
    private $profileName;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_libelle", type="string", length=250, nullable=true)
     */
    private $profileLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_description", type="text", nullable=true)
     */
    private $profileDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="profile_last_update", type="datetime", nullable=true)
     */
    private $profileLastUpdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntUser", mappedBy="fkUpProfile")
     */
    private $fkUpUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkUpUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get profileId
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set profileLdap
     *
     * @param string $profileLdap
     *
     * @return EntProfile
     */
    public function setProfileLdap($profileLdap)
    {
        $this->profileLdap = $profileLdap;

        return $this;
    }

    /**
     * Get profileLdap
     *
     * @return string
     */
    public function getProfileLdap()
    {
        return $this->profileLdap;
    }

    /**
     * Set profileName
     *
     * @param string $profileName
     *
     * @return EntProfile
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;

        return $this;
    }

    /**
     * Get profileName
     *
     * @return string
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * Set profileLibelle
     *
     * @param string $profileLibelle
     *
     * @return EntProfile
     */
    public function setProfileLibelle($profileLibelle)
    {
        $this->profileLibelle = $profileLibelle;

        return $this;
    }

    /**
     * Get profileLibelle
     *
     * @return string
     */
    public function getProfileLibelle()
    {
        return $this->profileLibelle;
    }

    /**
     * Set profileDescription
     *
     * @param string $profileDescription
     *
     * @return EntProfile
     */
    public function setProfileDescription($profileDescription)
    {
        $this->profileDescription = $profileDescription;

        return $this;
    }

    /**
     * Get profileDescription
     *
     * @return string
     */
    public function getProfileDescription()
    {
        return $this->profileDescription;
    }

    /**
     * Set profileLastUpdate
     *
     * @param \DateTime $profileLastUpdate
     *
     * @return EntProfile
     */
    public function setProfileLastUpdate($profileLastUpdate)
    {
        $this->profileLastUpdate = $profileLastUpdate;

        return $this;
    }

    /**
     * Get profileLastUpdate
     *
     * @return \DateTime
     */
    public function getProfileLastUpdate()
    {
        return $this->profileLastUpdate;
    }

    /**
     * Add fkUpUser
     *
     * @param \Ent\Entity\EntUser $fkUpUser
     *
     * @return EntProfile
     */
    public function addFkUpUser(\Doctrine\Common\Collections\Collection $fkUpUser)
    {
        /* @var $user \Ent\Entity\EntUser */
        foreach($fkUpUser as $user) {
            if( ! $this->fkUpUser->contains($user)) {
                $this->fkUpUser->add($user);
                $user->addFkUpProfile(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
            }
        }
    }

    /**
     * Remove fkUpUser
     *
     * @param \Ent\Entity\EntUser $fkUpUser
     */
    public function removeFkUpUser(\Doctrine\Common\Collections\Collection $fkUpUser)
    {
        /* @var $user \Ent\Entity\EntUser */
        foreach ($fkUpUser as $user) {
            $this->fkUpUser->removeElement($user);
            $user->removeFkUpProfile(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
        }
    }

    /**
     * Get fkUpUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUpUser()
    {
        return $this->fkUpUser;
    }
}
