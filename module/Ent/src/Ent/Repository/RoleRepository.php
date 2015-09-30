<?php

namespace Ent\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of RoleRepository
 *
 * @author egrondin
 */
class RoleRepository extends EntityRepository
{
    
    public function findAllExceptOne($roleID = 0)
    {
        /* @var $query \Doctrine\Common\Collections\Criteria */
        $query = $this->createQueryBuilder('r');
        $query->select('r')->where($query->expr()->notIn('r.id', $roleID));
        return $query->getQuery()->getResult();
    }
}
