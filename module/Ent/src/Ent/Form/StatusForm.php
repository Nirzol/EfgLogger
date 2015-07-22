<?php

namespace Ent\Form;

use Zend\Form\Form;

class StatusForm extends Form
{
    public function __construct() {
        parent::__construct('status');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        
        $element = new \Zend\Form\Element\Text('statusName');
        $element->setLabel('Nom du status : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Text('statusLibelle');
        $element->setLabel('Libellé du status : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Textarea('statusDescription');
        $element->setLabel('Description du status : ');
        $this->add($element);
    }
}
