<?php

namespace Ent\Form;

use Zend\Form\Form;

class ActionForm extends Form
{
    public function __construct() {
        parent::__construct('action');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        
        $element = new \Zend\Form\Element\Text('actionName');
        $element->setLabel('Nom de l\'action : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Text('actionLibelle');
        $element->setLabel('Libellé de l\'action  : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Textarea('actionDescription');
        $element->setLabel('Description de l\'action  : ');
        $this->add($element);
    }
}
