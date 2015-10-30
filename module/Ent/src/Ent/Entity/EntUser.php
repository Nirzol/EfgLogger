<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;

/**
 * EntUser
 *
 * @ORM\Table(name="ent_user", uniqueConstraints={@ORM\UniqueConstraint(name="login", columns={"user_login"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class EntUser extends Ent implements \ZfcRbac\Identity\IdentityInterface
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
     * @ORM\Column(name="user_login", type="string", length=80, nullable=false, unique=true)
     */
    private $userLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="user_password", type="string", length=64, nullable=true)
     */
    private $userPassword = '';

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
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntContact", mappedBy="fkUcUser")
     * @MaxDepth(1)
     * @Groups({"fkUcContact"})
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
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntHierarchicalRole", inversedBy="fkUrUser")
     * @ORM\JoinTable(name="ent_user_role",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_ur_user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_ur_role_id", referencedColumnName="id")
     *   }
     * )  
     */
    private $fkUrRole = [];

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
     * Set userId
     *
     * @param int $userId
     *
     * @return EntUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
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
     * Add contact
     *
     * @param EntContact $contact
     *
     * @return EntContact
     */
    public function addContact($contact)
    {
        $this->fkUcContact[] = $contact;

        return $this;
    }

    /**
     * Add fkUcContact
     *
     * @param \Doctrine\Common\Collections\Collection $fkUcContact
     */
    public function addFkUcContact(\Doctrine\Common\Collections\ArrayCollection $fkUcContact)
    {
        foreach ($fkUcContact as $contact) {
            $this->addContact($contact);
        }
    }

    /**
     * Remove contact
     *
     * @param \Ent\Entity\EntContact $contact
     */
    public function removeContact(\Ent\Entity\EntContact $contact)
    {
        $this->fkUcContact->removeElement($contact);
    }

    /**
     * Remove fkUcContact
     *
     * @param \Doctrine\Common\Collections\Collection $fkUcContact
     */
    public function removeFkUcContact(\Doctrine\Common\Collections\ArrayCollection $fkUcContact)
    {
        foreach ($fkUcContact as $contact) {
            $this->removeContact($contact);
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
     * Add profile
     *
     * @param EntProfile $profile
     *
     * @return EntProfile
     */
    public function addProfile($profile)
    {
        $this->fkUpProfile[] = $profile;

        return $this;
    }

    /**
     * Add fkUpProfile
     *
     * @param \Doctrine\Common\Collections\Collection $fkUpProfile
     */
    public function addFkUpProfile(\Doctrine\Common\Collections\ArrayCollection $fkUpProfile)
    {
        foreach ($fkUpProfile as $profile) {
            $this->addProfile($profile);
        }
    }

    /**
     * Remove profile
     *
     * @param \Ent\Entity\EntProfile $profile
     */
    public function removeProfile(\Ent\Entity\EntProfile $profile)
    {
        $this->fkUpProfile->removeElement($profile);
    }

    /**
     * Remove fkUpProfile
     *
     * @param \Doctrine\Common\Collections\Collection $fkUpProfile
     */
    public function removeFkUpProfile(\Doctrine\Common\Collections\ArrayCollection $fkUpProfile)
    {
        foreach ($fkUpProfile as $profile) {
            $this->removeProfile($profile);
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
     * Add role
     *
     * @param EntHierarchicalRole $role
     *
     * @return EntHierarchicalRole
     */
    public function addRole($role)
    {
        $this->fkUrRole[] = $role;

        return $this;
    }

    /**
     * Add fkUrRole
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrRole
     */
    public function addFkUrRole(\Doctrine\Common\Collections\ArrayCollection $fkUrRole)
    {
        foreach ($fkUrRole as $role) {
            $this->addRole($role);
        }
    }

    /**
     * Remove role
     *
     * @param \Ent\Entity\EntHierarchicalRole $role
     */
    public function removeRole(\Ent\Entity\EntHierarchicalRole $role)
    {
        $this->fkUrRole->removeElement($role);
    }

    /**
     * Remove fkUrRole
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrRole
     */
    public function removeFkUrRole(\Doctrine\Common\Collections\ArrayCollection $fkUrRole)
    {
        foreach ($fkUrRole as $role) {
            $this->removeRole($role);
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

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->getFkUrRole()->toArray();
    }
    
    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUserLastUpdate(date_create(date('Y-m-d H:i:s'))); //date('Y-m-d H:i:s')  new \DateTime("now")
    }

}
