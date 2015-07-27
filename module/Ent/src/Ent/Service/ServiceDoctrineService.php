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
class ServiceDoctrineService implements ServiceServiceInterface{
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

    public function __construct(EntityManager $em, EntService $service, DoctrineObject $hydrator, ServiceInputFilter $serviceInputFilter)
    {
        $this->em = $em;
        $this->service = $service;
        $this->hydrator = $hydrator;
        $this->serviceInputFilter = $serviceInputFilter;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntService');

        return $repo->findAll();
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

    public function insert(Form $form, $dataAssoc)
    {
        $service = $this->service;

        $form->setHydrator($this->hydrator);

        $form->bind($service);
        $form->setInputFilter($this->serviceInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        $this->em->persist($service);
        $this->em->flush();

        return $service;
    }

    public function save(Form $form, $dataAssoc, EntService $service = null)
    {
        if (!$service === null) {
            $service = $this->service;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($service);
        $form->setInputFilter($this->serviceInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
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
