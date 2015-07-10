<?php

namespace Ent\Form;

use Zend\Form\Form;

class ModuleForm extends Form
{
    public function __construct() {
        parent::__construct('module');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods());
        
        $element = new \Zend\Form\Element\Text('moduleName');
        $element->setLabel('Nom du module : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Text('moduleLibelle');
        $element->setLabel('Libellé du module : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Textarea('moduleDescription');
        $element->setLabel('Description du module : ');
        $this->add($element);
        
//        $element = new \Zend\Form\Element\DateTime('moduleLastUpdate');
//        $element->setLabel('Date de création : ');
//        $element->setFormat('Y-m-d');
//        $element->setValue(date('Y-m-d'));
//        $this->add($element);
    }
}
