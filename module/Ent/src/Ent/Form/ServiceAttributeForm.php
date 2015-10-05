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
        parent::__construct('service_attribute_form');
        
        $this->entityManager = $entityManager;
        
//        $this->add(array(
//             'type' => 'Ent\Form\ServiceAttributeFieldset',
//             'options' => array(
//                 'use_as_base_fieldset' => true,
//                 'target_class' => 'Ent\Form\ServiceAttributeFieldset',
//             ),
//         ));

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
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkSaService',
            'attributes' => array(
                'id' => 'selectService'
            ),
            'options' => array(
                'label' => 'Service : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntService',
                'empty_option' => '---Select Service---',
                'property' => 'serviceName',
                'is_method' => true,
            ),
        ));
        
        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkSaAttribute',
            'attributes' => array(
                'id' => 'selectAttribute'
            ),
            'options' => array(
                'label' => 'Attribute : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntAttribute',
                'empty_option' => '---Select Attribute---',
                'property' => 'attributeName',
                'is_method' => true,
            ),
        ));
    }
}
