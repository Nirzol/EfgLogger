<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntList;
use Ent\InputFilter\ListInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class ListDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntList
     */
    protected $list;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ListInputFilter
     */
    protected $listInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntList $list, DoctrineObject $hydrator, $listInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->list = $list;
        $this->hydrator = $hydrator;
        $this->listInputFilter = $listInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        // First check permission
//        if (!$this->authorizationService->isGranted('read')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $repo = $this->em->getRepository('Ent\Entity\EntList');

        return $repo->findAll();
    }

//    public function getAllRest()
//    {
//        $repo = $this->em->getRepository('Ent\Entity\EntList')->createQueryBuilder('List');
//
//        return $repo->getQuery()->getArrayResult();
//    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntList');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntList');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntList');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntList');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
//        $list = $this->list;
//
//        $form->setHydrator($this->hydrator);
//        $form->bind($list);
//        $filter = $this->listInputFilter;
//        $form->setInputFilter($filter->appendAddValidator());
//        $form->setData($dataAssoc);
//
//        if (!$form->isValid()) {
//            $this->addFormMessageToErrorLog($form->getMessages());
//            return null;
//        }
//
//        $this->em->persist($list);
//        $this->em->flush();
//
//        return $list;
    }

    public function save(Form $form, $dataAssoc, $list = null)
    {
        /* @var $list EntList */
//        if (!$list === null) {
//            $list = $this->list;
//        }
//
//        $form->setHydrator($this->hydrator);
//        $form->bind($list);
//        $filter = $this->listInputFilter;
//        $form->setInputFilter($filter->appendEditValidator($list->getListId()));
//        $form->setData($dataAssoc);
//
//        if (!$form->isValid()) {
//            $this->addFormMessageToErrorLog($form->getMessages());
//            return null;
//        }
//
//        $this->em->persist($list);
//        $this->em->flush();
//
//        return $list;
    }

    public function delete($id)
    {
        $list = $this->getById($id);

        // First check permission
//        if (!$this->authorizationService->isGranted('delete')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $this->em->remove($list);
        $this->em->flush();
    }

}
