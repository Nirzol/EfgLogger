<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntPermission;
use Ent\InputFilter\PermissionInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class PermissionDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntPermission
     */
    protected $permission;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var PermissionInputFilter
     */
    protected $permissionInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntPermission $permission, DoctrineObject $hydrator, PermissionInputFilter $permissionInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->permission = $permission;
        $this->hydrator = $hydrator;
        $this->permissionInputFilter = $permissionInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPermission');

        return $repo->findAll();
    }

    public function getAllRest()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPermission')->createQueryBuilder('Permission');

        return $repo->getQuery()->getArrayResult();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPermission');

        $repoFind = $repo->find($id);

        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPermission');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPermission');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $permission = $this->permission;

        $form->setHydrator($this->hydrator);
        $form->bind($permission);
        $filter = $this->permissionInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }
        $this->em->persist($permission);
        $this->em->flush();

        return $permission;
    }

    public function save(Form $form, $dataAssoc, $permission = null)
    {
        /* @var $permission EntPermission */
        if (!$permission === null) {
            $permission = $this->permission;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($permission);
        $filter = $this->permissionInputFilter;
        $form->setInputFilter($filter->appendEditValidator($permission->getId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($permission);
        $this->em->flush();

        return $permission;
    }

    public function delete($id)
    {
        $permission = $this->getById($id);
        
        $this->em->remove($permission);
        $this->em->flush();
    }

}
