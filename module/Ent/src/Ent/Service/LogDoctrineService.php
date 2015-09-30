<?php

namespace Ent\Service;

use Ent\Service\GenericEntityServiceInterface;
use Zend\Form\Form;
//use Ent\InputFilter\LogInputFilter;
use Doctrine\ORM\EntityManager;
use Ent\Entity\EntLog;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Stdlib\Hydrator\ClassMethods;
use Ent\Entity\EntUser;


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
//    public function getUserByLogin($login) {
//        
//        $eoUser = NULL;
//        
//        try {
//            $repository = $this->em->getRepository('Ent\Entity\EntUser');
//            $users = $repository->findBy(array('userLogin' => $login));
//            $eoUser = $users[0];
//        } catch (Exception $exc) {
//            $eoUser = NULL;
//            error_log($exc->getTraceAsString());
//            return NULL;
//        }
//
//        return $eoUser;
//    }
    
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
        
        $anEntLog = NULL;
        
        if( isset($dataArray) && (count($dataArray) > 0)) {
            
            try {
                $anEntLog = new EntLog();

                $hydrator = new DoctrineObject($this->em);

                $hydrator->hydrate($dataArray, $anEntLog);

                $this->insertEnterpriseObject($anEntLog);

            } catch (Exception $exc) {
                // echo $exc->getTraceAsString();
                $anEntLog = NULL;
            }
        }
        
        return $anEntLog;
        
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
    
    public function logEvent($event) {
        
        if ( isset($event) && (strcmp($event, "") != 0) ) {
            
            /**
             * @var EntUser
             */
            $eoUser = $this->getUserByLogin("sebbar");
            if ( $eoUser) {
                // IP, Session, Action : a determiner
                $anEntLog = new EntLog();
                $anEntLog->setFkLogUser($eoUser)
                        ->setLogDatetime(new \DateTime())
                        ->setLogIp("192.88.99.00")
                        ->setLogLogin($eoUser->getLogin())
                        ->setLogSession("sesion_4578000987")
                        ->setLogUseragent("Agent Firefox");

                if(strcmp($event, "login") == 0) {
                    $anEntLog->setFkLogAction("Action_Login");
                } else if(strcmp($event, "logout") == 0) {
                    $anEntLog->setFkLogAction("Action_Logout");
                }
                $this->insertEnterpriseObject($eoUser);
            }

        }
    }
}
