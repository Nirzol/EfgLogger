<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Ent\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Role\HierarchicalRoleInterface;
use ZfcRbac\Permission\PermissionInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity
 * @ORM\Table(name="ent_role")
 */
class EntHierarchicalRole extends Ent implements HierarchicalRoleInterface
{

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role_name", type="string", length=48, unique=true, nullable=false)
     */
    protected $name;

    /**
     * @var HierarchicalRoleInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntHierarchicalRole")
     */
    protected $children = [];

    /**
     * @var PermissionInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntPermission", indexBy="permission_name", fetch="LAZY")
     */
    protected $permissions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="role_last_update", type="datetime", nullable=false)
     */
    private $lastUpdate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ent\Entity\EntUser", inversedBy="fkUrRole")
     * @ORM\JoinTable(name="ent_user_role",
     *   joinColumns={
     *     @ORM\JoinColumn(name="fk_ur_role_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="fk_ur_user_id", referencedColumnName="user_id")
     *   }
     * )
     */
    private $fkUrUser;

    /**
     * Init the Doctrine collection
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the role name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function addChild(HierarchicalRoleInterface $child)
    {
        $this->children[] = $child;
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission)
    {
        // This can be a performance problem if your role has a lot of permissions. Please refer
        // to the cookbook to an elegant way to solve this issue
//        return isset($this->permissions[(string) $permission]);

        $criteria = Criteria::create()->where(Criteria::expr()->eq('permission_name', (string) $permission));
        $result = $this->permissions->matching($criteria);

        return count($result) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritDoc}
     */
    public function hasChildren()
    {
        return !$this->children->isEmpty();
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     *
     * @return EntHierarchicalRole
     */
    public function setlastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime
     */
    public function getlastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Add fkUrUser
     *
     * @param \Doctrine\Common\Collections\Collection $fkUrUser 
     *
     * @return EntHierarchicalRole
     */
    public function addFkUrUser(\Doctrine\Common\Collections\Collection $fkUrUser)
    {
        /* @var $user \Ent\Entity\EntUser */
        foreach ($fkUrUser as $user) {
            if (!$this->fkUrUser->contains($user)) {
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
        foreach ($fkUrUser as $user) {
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
