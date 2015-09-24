<?php

namespace Ent\Service;

use Ent\Entity\EntHierarchicalRole;
use Ent\InputFilter\RoleInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class RoleDoctrineService implements RoleServiceInterface
{
    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var \Ent\Entity\EntHierarchicalRole
     */
    protected $role;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var \Ent\InputFilter\RoleInputFilter
     */
    protected $roleInputFilter;

    /**
     *
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, \Ent\Entity\EntHierarchicalRole $role, DoctrineObject $hydrator, RoleInputFilter $roleInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
    {
        $this->entityManager = $em;
        $this->role = $role;
        $this->hydrator = $hydrator;
        $this->roleInputFilter = $roleInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repo = $this->entityManager->getRepository('Ent\Entity\EntHierarchicalRole');

        return $repo->findAll();
    }

    public function getAllRest()
    {
        $repo = $this->entityManager->getRepository('Ent\Entity\EntHierarchicalRole')->createQueryBuilder('Role');

        return $repo->getQuery()->getArrayResult();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->entityManager->getRepository('Ent\Entity\EntHierarchicalRole');

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
        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $role;
    }

    public function save(Form $form, $dataAssoc, \Ent\Entity\EntHierarchicalRole $role = null)
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

        $this->entityManager->persist($role);
        $this->entityManager->flush();

        return $role;
    }

    public function delete($id)
    {
        $role = $this->getById($id);
        
        // First check permission
//        if (!$this->authorizationService->isGranted('delete')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $this->entityManager->remove($role);
        $this->entityManager->flush();
    }
    
    public function update($id, Form $form, $dataAssoc){
        $role = $this->entityManager->find('Ent\Entity\EntHierarchicalRole', $id);
        
        $hydrator = new DoctrineObject($this->entityManager);
        
        $form->setHydrator($hydrator);        
        $form->bind($role);
        $form->setInputFilter(new RoleInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            error_log("==== Erreur: RoleDoctrineService.update: form is not valide !");
        } else {
            // Enregistrement dans la base
            $this->entityManager->persist($role);
            $this->entityManager->flush();
        }
        
        return $role;
        
    }
    
}
