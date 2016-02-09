<?php

namespace Ent\Service;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntListtype;
use Ent\InputFilter\ListtypeInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class ListtypeDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntListtype
     */
    protected $listtype;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ListtypeInputFilter
     */
    protected $listtypeInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntListtype $listtype, DoctrineObject $hydrator, ListtypeInputFilter $listtypeInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->listtype = $listtype;
        $this->hydrator = $hydrator;
        $this->listtypeInputFilter = $listtypeInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        // First check permission
//        if (!$this->authorizationService->isGranted('read')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $repo = $this->em->getRepository('Ent\Entity\EntListtype');

        return $repo->findAll();
    }

//    public function getAllRest()
//    {
//        $repo = $this->em->getRepository('Ent\Entity\EntListtype')->createQueryBuilder('Listtype');
//
//        return $repo->getQuery()->getArrayResult();
//    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntListtype');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntListtype');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntListtype');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntListtype');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $listtype = $this->listtype;

        $form->setHydrator($this->hydrator);
        $form->bind($listtype);
        $filter = $this->listtypeInputFilter;
        $form->setInputFilter($filter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($listtype);
        $this->em->flush();

        return $listtype;
    }

    public function save(Form $form, $dataAssoc, $listtype = null)
    {
        /* @var $listtype EntListtype */
        if (!$listtype === null) {
            $listtype = $this->listtype;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($listtype);
        $filter = $this->listtypeInputFilter;
        $form->setInputFilter($filter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($listtype);
        $this->em->flush();

        return $listtype;
    }

    public function delete($id)
    {
        $listtype = $this->getById($id);

        // First check permission
//        if (!$this->authorizationService->isGranted('delete')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $this->em->remove($listtype);
        $this->em->flush();
    }

}
