<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use Ent\Entity\EntLove;

/**
 * Description of LoveDoctrineService
 *
 * @author fandria
 */
class LoveDoctrineService extends DoctrineService {
     /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntLove
     */
    protected $love;

    public function __construct(EntityManager $em, EntLove $love)
    {
        $this->em = $em;
        $this->love = $love;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntLove');

        return $repository->findAll();
    }
}
