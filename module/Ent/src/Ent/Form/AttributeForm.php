<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class AttributeForm extends Form
{
    
    protected $entityManager;
    
    public function __construct(EntityManager $entityManager) {
        parent::__construct('attribute');
        
        $this->entityManager = $entityManager;
        
        $element = new \Zend\Form\Element\Text('attributeName');
        $element->setLabel('Nom de l\'attribut : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Text('attributeLibelle');
        $element->setLabel('Libellé de l\'attribut : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Textarea('attributeDescription');
        $element->setLabel('Description de l\'attribut :');
        $this->add($element);
        
//        $this->add(array(
//            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
//            'name' => 'fkSaService',
//            'attributes' => array(
//                'id' => 'selectAttributeService'
//            ),
//            'options' => array(
//                'label' => 'Service : ',
//                'object_manager' => $this->entityManager,
//                'target_class' => 'Ent\Entity\EntService',
//                'property' => 'serviceLibelle',
//                'is_method' => true,
//            ),
//        ));
        
    }
}
