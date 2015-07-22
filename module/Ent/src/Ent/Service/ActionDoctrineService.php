<?php

namespace Ent\Service;

use Ent\Entity\EntAction;
use Ent\InputFilter\ActionInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class ActionDoctrineService implements ActionServiceInterface
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
        $repository = $this->em->getRepository('Ent\Entity\EntAction');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntAction');
        
        $repoFind = $repository->find($id);
        
        if ($form != null) {
            $hydrator = new DoctrineObject($this->em);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }

    public function insert(Form $form, $dataAssoc) {
        $action = new EntAction();
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($action);
        $form->setInputFilter(new ActionInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($action);
        $this->em->flush();
        
        return $action;
        
    }

    public function update($id, Form $form, $dataAssoc) {
        $action = $this->em->find('Ent\Entity\EntAction', $id);
        
        $hydrator = new DoctrineObject($this->em);
        
        $form->setHydrator($hydrator);
        $form->bind($action);
        $form->setInputFilter(new ActionInputFilter());
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($action);
        $this->em->flush();
        
        return $action;
    }
    
    public function delete($id) {
        $action = $this->em->find('Ent\Entity\EntAction', $id);
        
        $this->em->remove($action);
        $this->em->flush();
        
        return $action;
    }

}
