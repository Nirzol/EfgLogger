<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Description of ServiceAttributeForm
 *
 * @author fandria
 */
class ServiceAttributeForm extends Form{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('service');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'serviceAttributeValue',
            'options' => array(
                'label' => 'Name : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'serviceLibelle',
            'options' => array(
                'label' => 'Libelle : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'serviceDescription',
            'options' => array(
                'label' => 'Description : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
//        $this->add(array(
//            'type' => '\DoctrineModule\Form\Element\ObjectRadio', 
//            'name' => 'fkContactStructure',
//            'attributes' => array(
//                'id' => 'selectContactStructure'
//            ),
//            'options' => array(
//                'label' => 'Structure : ',
//                'object_manager' => $this->entityManager,
//                'target_class' => 'Ent\Entity\EntStructure',
//                'property' => 'structureLibelle',
//                'is_method' => true
//            ),
//        ));
//        
//        $this->add(array(
//            'type' => '\DoctrineModule\Form\Element\ObjectRadio', 
//            'name' => 'fkContactStructure',
//            'attributes' => array(
//                'id' => 'selectContactStructure'
//            ),
//            'options' => array(
//                'label' => 'Structure : ',
//                'object_manager' => $this->entityManager,
//                'target_class' => 'Ent\Entity\EntStructure',
//                'property' => 'structureLibelle',
//                'is_method' => true
//            ),
//        ));
    }
}
