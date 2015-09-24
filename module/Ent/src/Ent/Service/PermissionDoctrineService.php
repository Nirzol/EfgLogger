<?php

namespace Ent\Service;

use Ent\Entity\EntPermission;
use Ent\InputFilter\PermissionInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class PermissionDoctrineService implements PermissionServiceInterface
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
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntPermission $permission, DoctrineObject $hydrator, PermissionInputFilter $permissionInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
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
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
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
            return null;
        }
        $this->em->persist($permission);
        $this->em->flush();

        return $permission;
    }

    public function save(Form $form, $dataAssoc, EntPermission $permission = null)
    {
        if (!$permission === null) {
            $permission = $this->permission;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($permission);
        $filter = $this->permissionInputFilter;
        $form->setInputFilter($filter->appendEditValidator($permission->getId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
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
