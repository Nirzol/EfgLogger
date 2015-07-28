<?php

namespace Ent\Service;

use Ent\Service\GenericEntityServiceInterface;
use Zend\Form\Form;
//use Ent\InputFilter\LogInputFilter;
use Doctrine\ORM\EntityManager;
use Ent\Entity\EntLog;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Stdlib\Hydrator\ClassMethods;


class LogDoctrineService implements GenericEntityServiceInterface {
    
    /**
     * @var EntityManager
     */
    protected $em;
   
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntLog');
        
        return $repository->findAll();
    }
    
    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntLog');
        
        $repoFind = $repository->find($id);
        
        if($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }
    
    public function insertArray(Array $dataAarray=array()) {
        $eo = null;
        
        if( isset($dataAarray)) {
            $eo = new EntLog();

            $hydrator = new ClassMethods();

            // cree l'objet 
            $eo = $hydrator->hydrate($dataAarray, $eo);

            $this->em->persist($eo);
            $this->em->flush();
            return $eo;
        }
        
        return null;
        
    }
    
    public function insertEnterpriseObject($eo) {
        

        if( isset($eo) && ($eo instanceof EntLog) ) {  
            $this->em->persist($eo);
            $this->em->flush();
            return $eo;
        }
        
        return null;
        
    }

    /**
     * Sauvegarde d'un eo
     * 
     */
    public function updateEnterpriseObject($eo) {
        
        if( isset($eo) && ($eo instanceof EntLog) ) {
            $this->em->refresh($eo);
            $this->em->flush();
            return $eo;
        }

        return null;
    }
    
    public function insert(Form $form, $dataAssoc) {
        $eo = new EntLog();
        
        $hydrator = new DoctrineObject($this->em);
        $form->setHydrator($hydrator);
        
        $form->bind($eo);
//        $form->setInputFilter(new LogInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($eo);
        $this->em->flush();
        
        return $eo;
        
    }

    public function update($id, Form $form, $dataAssoc){
        $eo = $this->em->find('Ent\Entity\EntLog', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);        
        $form->bind($eo);
//        $form->setInputFilter(new LogInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            error_log("ProfileDoctrineService.update: form is not valide !");
            return null;
        }
        
        $this->em->persist($eo);
        $this->em->flush();
        
        return $eo;
        
    }
    
    public function delete($id){
        
        $eo = $this->em->find('Ent\Entity\EntLog', $id);
        
        $this->em->remove($eo);
        $this->em->flush();
        
        return $eo;
    }
    
    
}
