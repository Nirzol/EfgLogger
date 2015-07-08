<?php

namespace Ent\Service;

use Ent\Entity\EntModule;
use Ent\InputFilter\ModuleInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class ModuleDoctrineService implements ModuleServiceInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
   
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntModule');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntModule');
        
        $repoFind = $repository->find($id);
        
        if($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }

    public function insert(Form $form, $dataAssoc) {
        $module = new EntModule();
        
        $hydrator = new DoctrineObject($this->em);
        $form->setHydrator($hydrator);
        
        $form->bind($module);
        $form->setInputFilter(new ModuleInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($module);
        var_dump($module);
        $this->em->flush();
        
        return $module;
        
    }

    public function update($id, Form $form, $dataAssoc) {
        $module = $this->em->find('Ent\Entity\EntModule', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);        
        $form->bind($module);
        $form->setInputFilter(new ModuleInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($module);
        $this->em->flush();
        
        return $module;
        
    }
    
    public function delete($id) {
        $module = $this->em->find('Ent\Entity\EntModule', $id);
        
        $this->em->remove($module);
        $this->em->flush();
        
        return $module;
    }

}
