<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntHierarchicalRole;
use Ent\InputFilter\RoleInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class RoleDoctrineService implements RoleServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntHierarchicalRole
     */
    protected $role;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var RoleInputFilter
     */
    protected $roleInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntHierarchicalRole $role, DoctrineObject $hydrator, RoleInputFilter $roleInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->role = $role;
        $this->hydrator = $hydrator;
        $this->roleInputFilter = $roleInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntHierarchicalRole');

        return $repo->findAll();
    }

    public function getAllRest()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntHierarchicalRole')->createQueryBuilder('Role');

        return $repo->getQuery()->getArrayResult();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntHierarchicalRole');

        $repoFind = $repo->find($id);
        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $role = $this->role;

        $form->setHydrator($this->hydrator);

        $form->bind($role);
        $form->setInputFilter($this->roleInputFilter);
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }

    public function save(Form $form, $dataAssoc, EntHierarchicalRole $role = null)
    {
        if (!$role === null) {
            $role = $this->role;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($role);
        $form->setInputFilter($this->roleInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }

        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }

    public function delete($id)
    {
        $role = $this->getById($id);

        // First check permission
//        if (!$this->authorizationService->isGranted('delete')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $this->em->remove($role);
        $this->em->flush();
    }
}
