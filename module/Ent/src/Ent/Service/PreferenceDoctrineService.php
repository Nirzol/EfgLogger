<?php

namespace Ent\Service;

use Zend\Form\Form;
use Ent\Entity\EntPreference;
use Ent\InputFilter\PreferenceInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class PreferenceDoctrineService implements PreferenceServiceInterface
{
    /**
     *
     * @var EntityManager
     */
    protected $em;
    
    /**
     *
     * @var EntPreference
     */
    protected $preference;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;
    
    /**
     *
     * @var PreferenceInputFilter
     */
    protected $preferenceFilter;
    
    public function __construct(EntityManager $em, EntPreference $preference, DoctrineObject $hydrator, PreferenceInputFilter $preferenceFilter) {
        $this->em = $em;
        $this->preference = $preference;
        $this->hydrator = $hydrator;
        $this->preferenceFilter = $preferenceFilter;
    }
    
    public function getAll() {
        $repository = $this->em->getRepository('Ent\Entity\EntPreference');
        
        return $repository->findAll();
    }

    public function getById($id, $form = null) {
        $repository = $this->em->getRepository('Ent\Entity\EntPreference');
        
        $repoFind = $repository->find($id);
        
        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }
        
        return $repoFind;
    }

    public function insert(Form $form, $dataAssoc) {
        $preference = $this->preference;
        
        $form->setHydrator($this->hydrator);
        $form->bind($preference);
        $form->setInputFilter($this->preferenceFilter);
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($preference);
        $this->em->flush();
        
        return $preference;
    }

    public function udpate($id, Form $form, $dataAssoc) {
        $preference = $this->em->find('Ent\Entity\EntPreference', $id);
        
        $form->setHydrator($this->hydrator);
        $form->bind($preference);
        $form->setInputFilter($this->preferenceFilter);
        $form->setData($dataAssoc);
        
        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($preference);
        $this->em->flush();
        
        return $preference;
    }
    
    public function delete($id) {
        $preference = $this->em->find('Ent\Entity\EntPreference', $id);
        
        $this->em->remove($preference);
        $this->em->flush();
        
        return $preference;
    }

}
