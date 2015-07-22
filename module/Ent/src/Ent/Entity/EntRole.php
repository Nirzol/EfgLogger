<?php

namespace Ent\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntRole
 *
 * @ORM\Table(name="ent_role")
 * @ORM\Entity
 */
class EntRole extends Ent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="role_name", type="string", length=250, nullable=false)
     */
    private $roleName;

    /**
     * @var string
     *
     * @ORM\Column(name="role_libelle", type="string", length=250, nullable=false)
     */
    private $roleLibelle;

    /**
     * @var string
     *
     * @ORM\Column(name="role_description", type="text", nullable=true)
     */
    private $roleDescription;

    /**
     * @var boolean
     *
     * @ORM\Column(name="role_is_default", type="boolean", nullable=false)
     */
    private $roleIsDefault = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="role_parent_id", type="integer", nullable=false)
     */
    private $roleParentId = '-1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="role_last_update", type="datetime", nullable=false)
     */
    private $roleLastUpdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntUser", inversedBy="fkUrRole")
     * @ORM\JoinTable(name="ent_user_role",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_ur_role_id", referencedColumnName="role_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_ur_user_id", referencedColumnName="user_id")
     *   }
     * )
     */
    private $fkUrUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkUrUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get roleId
     *
     * @return integer
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set roleName
     *
     * @param string $roleName
     *
     * @return EntRole
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get roleName
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set roleLibelle
     *
     * @param string $roleLibelle
     *
     * @return EntRole
     */
    public function setRoleLibelle($roleLibelle)
    {
        $this->roleLibelle = $roleLibelle;

        return $this;
    }

    /**
     * Get roleLibelle
     *
     * @return string
     */
    public function getRoleLibelle()
    {
        return $this->roleLibelle;
    }

    /**
     * Set roleDescription
     *
     * @param string $roleDescription
     *
     * @return EntRole
     */
    public function setRoleDescription($roleDescription)
    {
        $this->roleDescription = $roleDescription;

        return $this;
    }

    /**
     * Get roleDescription
     *
     * @return string
     */
    public function getRoleDescription()
    {
        return $this->roleDescription;
    }

    /**
     * Set roleIsDefault
     *
     * @param boolean $roleIsDefault
     *
     * @return EntRole
     */
    public function setRoleIsDefault($roleIsDefault)
    {
        $this->roleIsDefault = $roleIsDefault;

        return $this;
    }

    /**
     * Get roleIsDefault
     *
     * @return boolean
     */
    public function getRoleIsDefault()
    {
        return $this->roleIsDefault;
    }

    /**
     * Set roleParentId
     *
     * @param integer $roleParentId
     *
     * @return EntRole
     */
    public function setRoleParentId($roleParentId)
    {
        $this->roleParentId = $roleParentId;

        return $this;
    }

    /**
     * Get roleParentId
     *
     * @return integer
     */
    public function getRoleParentId()
    {
        return $this->roleParentId;
    }

    /**
     * Set roleLastUpdate
     *
     * @param \DateTime $roleLastUpdate
     *
     * @return EntRole
     */
    public function setRoleLastUpdate($roleLastUpdate)
    {
        $this->roleLastUpdate = $roleLastUpdate;

        return $this;
    }

    /**
     * Get roleLastUpdate
     *
     * @return \DateTime
     */
    public function getRoleLastUpdate()
    {
        return $this->roleLastUpdate;
    }

    /**
     * Add fkUrUser
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrUser 
     *
     * @return EntRole
     */
    public function addFkUrUser(\Doctrine\Common\Collections\Collection $fkUrUser)
    {
        /* @var $user \Ent\Entity\EntUser */
        foreach($fkUrUser as $user) {
            if( ! $this->fkUrUser->contains($user)) {
                $this->fkUrUser->add($user);
//                $user->addFkUrUser(new ArrayCollection(array($this)));
            }
        }
    }

    /**
     * Remove fkUrUser
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrUser
     */
    public function removeFkUrUser(\Doctrine\Common\Collections\Collection $fkUrUser)
    {
        foreach($fkUrUser as $user) {
            $this->fkUrUser->removeElement($user);
//                $user->addFkUrUser(new ArrayCollection(array($this)));
        }
    }

    /**
     * Get fkUrUser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkUrUser()
    {
        return $this->fkUrUser;
    }
}
