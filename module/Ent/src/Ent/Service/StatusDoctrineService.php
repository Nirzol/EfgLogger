<?php

namespace Ent\Service;

use Ent\Entity\EntStatus;
use Ent\InputFilter\StatusInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class StatusDoctrineService implements StatusServiceInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntStatus');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntStatus');
        
        $repoFind = $repository->find($id);
        
        if($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;       
    }

    public function insert(Form $form, $dataAssoc) {
        $status = new EntStatus();
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);       
        $form->bind($status);
        $form->setInputFilter(new StatusInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($status);
        $this->em->flush();
        
        return $status;
    }

    public function update($id, Form $form, $dataAssoc) {
        $status = $this->em->find('Ent\Entity\EntStatus', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($status);
        $form->setInputFilter(new StatusInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($status);
        $this->em->flush();
        
        return $status;
        
    }
    
    public function delete($id) {
        $status = $this->em->find('Ent\Entity\EntStatus', $id);
        
        $this->em->remove($status);
        $this->em->flush();
        
        return $status;
    }

}
