<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntServiceAttribute;
use Ent\InputFilter\ServiceAttributeInputFilter;
use Zend\Form\Form;

/**
 * Description of ServiceAttributeDoctrineService
 *
 * @author fandria
 */
class ServiceAttributeDoctrineService implements ServiceAttributeServiceInterface{
    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntServiceAttribute
     */
    protected $serviceAttribute;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ServiceAttributeInputFilter
     */
    protected $serviceAttributeInputFilter;

    public function __construct(EntityManager $em, EntServiceAttribute $serviceAttribute, DoctrineObject $hydrator, ServiceAttributeInputFilter $serviceAttributeInputFilter)
    {
        $this->em = $em;
        $this->serviceAttribute = $serviceAttribute;
        $this->hydrator = $hydrator;
        $this->serviceAttributeInputFilter = $serviceAttributeInputFilter;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntServiceAttribute');

        return $repo->findAll();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntServiceAttribute');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }
    
    public function getByServiceId($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntServiceAttribute');
        
        $repoFind = $repo->findBy(array('fkSaService' => $id));
        
        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
        
    }

    public function insert(Form $form, $dataAssoc)
    {
        $serviceAttribute = $this->serviceAttribute;

        $form->setHydrator($this->hydrator);

        $form->bind($serviceAttribute);
        $form->setInputFilter($this->serviceAttributeInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        $this->em->persist($serviceAttribute);
        $this->em->flush();

        return $serviceAttribute;
    }

    public function save(Form $form, $dataAssoc, EntServiceAttribute $serviceAttribute = null)
    {
        if (!$serviceAttribute === null) {
            $serviceAttribute = $this->serviceAttribute;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($serviceAttribute);
        $form->setInputFilter($this->serviceAttributeInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }

        $this->em->persist($serviceAttribute);
        $this->em->flush();

        return $serviceAttribute;
    }

    public function delete($id)
    {
        $this->em->remove($this->getById($id));
        $this->em->flush();
    }
}
