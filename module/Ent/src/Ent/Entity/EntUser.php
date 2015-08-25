<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntUser
 *
 * @ORM\Table(name="ent_user", uniqueConstraints={@ORM\UniqueConstraint(name="login", columns={"user_login"})})
 * @ORM\Entity
 */
class EntUser extends Ent
{

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=80, nullable=false)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=64, nullable=false)
     */
    private $userPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_last_connection", type="datetime", nullable=true)
     */
    private $userLastConnection;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_last_update", type="datetime", nullable=true)
     */
    private $userLastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="user_status", type="boolean", nullable=false)
     */
    private $userStatus = '1';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntContact", inversedBy="fkUcUser")
     * @ORM\JoinTable(name="ent_user_contact",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_uc_user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_uc_contact_id", referencedColumnName="contact_id")
     *   }
     * )
     */
    private $fkUcContact;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntProfile", inversedBy="fkUpUser")
     * @ORM\JoinTable(name="ent_user_profile",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_up_user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_up_profile_id", referencedColumnName="profile_id")
     *   }
     * )
     */
    private $fkUpProfile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntRole", mappedBy="fkUrUser")
     */
    private $fkUrRole;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkUcContact = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkUpProfile = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkUrRole = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userLogin
     *
     * @param string $userLogin
     *
     * @return EntUser
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    /**
     * Get userLogin
     *
     * @return string
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Get userPassword
     *
     * @return string
     */
    function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set userPassword
     *
     * @param string $userPassword
     *
     * @return EntUser
     */
    function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * Set userLastConnection
     *
     * @param \DateTime $userLastConnection
     *
     * @return EntUser
     */
    public function setUserLastConnection($userLastConnection)
    {
        $this->userLastConnection = $userLastConnection;

        return $this;
    }

    /**
     * Get userLastConnection
     *
     * @return \DateTime
     */
    public function getUserLastConnection()
    {
        return $this->userLastConnection;
    }

    /**
     * Set userLastUpdate
     *
     * @param \DateTime $userLastUpdate
     *
     * @return EntUser
     */
    public function setUserLastUpdate($userLastUpdate)
    {
        $this->userLastUpdate = $userLastUpdate;

        return $this;
    }

    /**
     * Get userLastUpdate
     *
     * @return \DateTime
     */
    public function getUserLastUpdate()
    {
        return $this->userLastUpdate;
    }

    /**
     * Set userStatus
     *
     * @param boolean $userStatus
     *
     * @return EntUser
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;

        return $this;
    }

    /**
     * Get userStatus
     *
     * @return boolean
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * Add fkUcContact
     *
     * @param \Ent\Entity\EntContact $fkUcContact
     *
     * @return EntUser
     */
    public function addFkUcContact(\Doctrine\Common\Collections\Collection $fkUcContact)
    {
        /* @var $contact \Ent\Entity\EntContact */
        foreach ($fkUcContact as $contact) {
            if (!$this->fkUcContact->contains($contact)) {
                $this->fkUcContact->add($contact);
            }
        }
    }

    /**
     * Remove fkUcContact
     *
     * @param \Ent\Entity\EntContact $fkUcContact
     */
    public function removeFkUcContact(\Doctrine\Common\Collections\Collection $fkUcContact)
    {
        /* @var $contact \Ent\Entity\EntContact */
        foreach ($fkUcContact as $contact) {
            $this->fkUcContact->removeElement($contact);
        }
    }

    /**
     * Get fkUcContact
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUcContact()
    {
        return $this->fkUcContact;
    }

    /**
     * Add fkUpProfile
     *
     * @param \Ent\Entity\EntProfile $fkUpProfile
     *
     * @return EntUser
     */
    public function addFkUpProfile(\Doctrine\Common\Collections\Collection $fkUpProfile)
    {
        /* @var $profile \Ent\Entity\EntProfile */
        foreach ($fkUpProfile as $profile) {
            if (!$this->fkUpProfile->contains($profile)) {
                $this->fkUpProfile->add($profile);
            }
        }
    }

    /**
     * Remove fkUpProfile
     *
     * @param \Ent\Entity\EntProfile $fkUpProfile
     */
    public function removeFkUpProfile(\Doctrine\Common\Collections\Collection $fkUpProfile)
    {
        /* @var $profile \Ent\Entity\EntProfile */
        foreach ($fkUpProfile as $profile) {
            $this->fkUpProfile->removeElement($profile);
        }
    }

    /**
     * Get fkUpProfile
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUpProfile()
    {
        return $this->fkUpProfile;
    }

    /**
     * Add fkUrRole
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrRole
     *
     * @return EntUser
     */
    public function addFkUrRole(\Doctrine\Common\Collections\Collection $fkUrRole)
    {
        /* @var $role \Ent\Entity\EntRole */
        foreach ($fkUrRole as $role) {
            if (!$this->fkUrRole->contains($role)) {
                $this->fkUrRole->add($role);
                $role->addFkUrUser(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
            }
        }
    }

    /**
     * Remove fkUrRole
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrRole
     */
    public function removeFkUrRole(\Doctrine\Common\Collections\Collection $fkUrRole)
    {
        /* @var $role \Ent\Entity\EntRole */
        foreach ($fkUrRole as $role) {
            $this->fkUrRole->removeElement($fkUrRole);
            $role->removeFkUrUser(new \Doctrine\Common\Collections\ArrayCollection(array($this)));
        }
    }

    /**
     * Get fkUrRole
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUrRole()
    {
        return $this->fkUrRole;
    }

}
