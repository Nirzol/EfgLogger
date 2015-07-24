<?php

namespace Ent\Service;

use Ent\Entity\EntAttribute;
use Ent\InputFilter\AttributeInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class AttributeDoctrineService implements AttributeServiceInterface 
{
    /**
     *
     * @var EntityManager
     */
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntAttribute');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntAttribute');
        
        $repoFind = $repository->find($id);
        
        if ($form != null) {
            $hydrator = new DoctrineObject($this->em);
            /* @var $form Form */
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }

    public function insert(Form $form, $dataAssoc) {
        $attribute = new EntAttribute();
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($attribute);
        $form->setInputFilter(new AttributeInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($attribute);
        $this->em->flush();
        
        return $attribute;
    }

    public function udpate($id, Form $form, $dataAssoc) {
        $attribute = $this->em->find('Ent\Entity\EntAttribute', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($attribute);
        $form->setInputFilter(new AttributeInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($attribute);
        $this->em->flush();
        
        return $attribute;
    }

    public function delete($id) {
        $attribute = $this->em->find('Ent\Entity\EntAttribute', $id);
        
        $this->em->remove($attribute);
        $this->em->flush();
        
        return $attribute;
    }

}
