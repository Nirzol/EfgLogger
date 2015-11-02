<?php

namespace Ent\Service;

use Ent\Entity\EntStatus;
use Ent\InputFilter\StatusInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class StatusDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntStatus
     */
    protected $status;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var StatusInputFilter
     */
    protected $statusInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntStatus $status, DoctrineObject $hydrator, StatusInputFilter $statusInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->status = $status;
        $this->hydrator = $hydrator;
        $this->statusInputFilter = $statusInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntStatus');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntStatus');

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
        $repo = $this->em->getRepository('Ent\Entity\EntStatus');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStatus');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStatus');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $status = $this->status;

        $form->setHydrator($this->hydrator);
        $form->bind($status);
        $filter = $this->statusInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($status);
        $this->em->flush();

        return $status;
    }

    public function save(Form $form, $dataAssoc, $status = null)
    {
        /* @var $status EntStatus */
        if (!$status === null) {
            $status = $this->status;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($status);
        $filter = $this->statusInputFilter;
        $form->setInputFilter($filter->appendEditValidator($status->getStatusId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($status);
        $this->em->flush();

        return $status;
    }

    public function delete($id)
    {
        $status = $this->getById($id);

        $this->em->remove($status);
        $this->em->flush();
    }

}
