<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Service;

use Ent\Service\GenericEntityServiceInterface;
use Zend\Form\Form;
use Doctrine\ORM\EntityManager;
use Ent\Entity\EntVersion;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

/**
 * Description of VersionDoctrineService
 *
 * @author sebbar
 */
class VersionDoctrineService implements GenericEntityServiceInterface {
    /**
     * @var EntityManager
     */
    protected $em;
   
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntVersion');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntVersion');
        
        $repoFind = $repository->find($id);
        
        if($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }
    
    public function insert(Form $form, $dataAssoc) {
        
    }
    
    public function update($id, Form $form, $dataAssoc) {
        
    }
    
    public function delete($id) {
        
    }
    
}
