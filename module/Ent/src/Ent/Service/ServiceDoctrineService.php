<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntService;
use Ent\InputFilter\ServiceInputFilter;
use Zend\Form\Form;

/**
 * Description of ServiceDoctrineService
 *
 * @author fandria
 */
class ServiceDoctrineService extends DoctrineService implements ServiceInterface
{
    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntService
     */
    protected $service;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ServiceInputFilter
     */
    protected $serviceInputFilter;

    public function __construct(EntityManager $em, EntService $service, DoctrineObject $hydrator, ServiceInputFilter $serviceInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->service = $service;
        $this->hydrator = $hydrator;
        $this->serviceInputFilter = $serviceInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        return $repo->findAll();
    }

    public function getAllWithPreference()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        return $repo->findAllWithPreference();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        $repoFindOneBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindOneBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $service = $this->service;

        $form->setHydrator($this->hydrator);
        $form->bind($service);
        $filter = $this->serviceInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }
        $this->em->persist($service);
        $this->em->flush();

        return $service;
    }

    public function save(Form $form, $dataAssoc, $service = null)
    {
        /* @var $user EntService */
        if (!$service === null) {
            $service = $this->service;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($service);
        $filter = $this->serviceInputFilter;
        $form->setInputFilter($filter->appendEditValidator($service->getServiceId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($service);
        $this->em->flush();

        return $service;
    }

    public function delete($id)
    {
        $this->em->remove($this->getById($id));
        $this->em->flush();
    }

}
