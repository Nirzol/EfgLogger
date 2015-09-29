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

    /**
     * 
     * @param type $login
     * @return type EntUser
     */
    public function getUserByLogin($login) {
        
        $eoUser = NULL;
        
        try {
            $repository = $this->em->getRepository('Ent\Entity\EntUser');
            $users = $repository->findBy(array('userLogin' => $login));
            $eoUser = $users[0];
        } catch (Exception $exc) {
            $eoUser = NULL;
            error_log($exc->getTraceAsString());
            return NULL;
        }

        return $eoUser;
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

    public function insertArray($dataArray) {
        
        if( isset($dataArray) && (count($dataArray) > 0)) {
            $anEntLog = new EntLog();

            $hydrator = new DoctrineObject($this->em);

            $hydrator->hydrate($dataArray, $anEntLog);
            
            $this->insertEnterpriseObject($anEntLog);

            return $anEntLog;
        }
        
        return NULL;
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
    
    public function updateArray($id, $dataArray){
        
        $anEntLog = $this->em->find('Ent\Entity\EntLog', $id);
        
        $hydrator = new DoctrineObject($this->em);
        $hydrator->hydrate($dataArray, $anEntLog);
        $this->insertEnterpriseObject($anEntLog);
        
        $this->em->persist($anEntLog);
        $this->em->flush();
        
        return $anEntLog;
        
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
