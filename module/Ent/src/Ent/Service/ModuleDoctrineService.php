<?php

namespace Ent\Service;

use Ent\Entity\EntModule;
use Ent\InputFilter\ModuleInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class ModuleDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntModule
     */
    protected $module;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ModuleInputFilter
     */
    protected $moduleInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntModule $module, DoctrineObject $hydrator, ModuleInputFilter $moduleInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->module = $module;
        $this->hydrator = $hydrator;
        $this->moduleInputFilter = $moduleInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntModule');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntModule');

        $repoFind = $repository->find($id);

        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntModule');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntModule');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntModule');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $module = $this->module;

        $form->setHydrator($this->hydrator);
        $form->bind($module);
        $filter = $this->moduleInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($module);
        $this->em->flush();

        return $module;
    }

    public function save(Form $form, $dataAssoc, $module = null)
    {
        /* @var $module EntModule */
        if (!$module === null) {
            $module = $this->module;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($module);
        $filter = $this->moduleInputFilter;
        $form->setInputFilter($filter->appendEditValidator($module->getModuleId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($module);
        $this->em->flush();

        return $module;
    }

    public function delete($id)
    {
        $module = $this->getById($id);

        $this->em->remove($module);
        $this->em->flush();
    }

}
