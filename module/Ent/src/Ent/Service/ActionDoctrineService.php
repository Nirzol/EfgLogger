<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAction;
use Ent\InputFilter\ActionInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class ActionDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntAction
     */
    protected $action;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ActionInputFilter
     */
    protected $actionInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntAction $action, DoctrineObject $hydrator, ActionInputFilter $actionInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->action = $action;
        $this->hydrator = $hydrator;
        $this->actionInputFilter = $actionInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntAction');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntAction');

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
        $repo = $this->em->getRepository('Ent\Entity\EntAction');

        $repoFindOneBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindOneBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntAction');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $action = $this->action;

        $form->setHydrator($this->hydrator);
        $form->bind($action);
        $filter = $this->actionInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($action);
        $this->em->flush();

        return $action;
    }

    public function save(Form $form, $dataAssoc, $action = null)
    {
        /* @var $action EntAction */
        if (!$action === null) {
            $action = $this->action;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($action);
        $filter = $this->actionInputFilter;
        $form->setInputFilter($filter->appendEditValidator($action->getActionId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($action);
        $this->em->flush();

        return $action;
    }

    public function delete($id)
    {
        $action = $this->getById($id);

        $this->em->remove($action);
        $this->em->flush();
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntAttribute');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

}
