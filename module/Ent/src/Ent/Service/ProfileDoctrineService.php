<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Service;

use Ent\Service\GenericEntityServiceInterface;
use Zend\Form\Form;
use Ent\InputFilter\ProfileInputFilter;
use Doctrine\ORM\EntityManager;
use Ent\Entity\EntProfile;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

/**
 * Description of ProfileDoctrineService
 *
 * @author sebbar
 */
class ProfileDoctrineService implements GenericEntityServiceInterface {
    
    /**
     * @var EntityManager
     */
    protected $em;
   
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntProfile');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntProfile');
        
        $repoFind = $repository->find($id);
        
        if($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }
    
    public function insert(Form $form, $dataAssoc) {
        $profile = new EntProfile();
        
        $hydrator = new DoctrineObject($this->em);
        $form->setHydrator($hydrator);
        
        $form->bind($profile);
        $form->setInputFilter(new ProfileInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($profile);
        $this->em->flush();
        
        return $profile;
        
    }

    public function update($id, Form $form, $dataAssoc){
        $profile = $this->em->find('Ent\Entity\EntProfile', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);        
        $form->bind($profile);
        $form->setInputFilter(new ProfileInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            error_log("ProfileDoctrineService.update: form is not valide !");
            return null;
        }
        
        $this->em->persist($profile);
        $this->em->flush();
        
        return $profile;
        
    }
    
    public function delete($id){
        
        $profile = $this->em->find('Ent\Entity\EntProfile', $id);
        
        $this->em->remove($profile);
        $this->em->flush();
        
        return $profile;
    }
    
}
