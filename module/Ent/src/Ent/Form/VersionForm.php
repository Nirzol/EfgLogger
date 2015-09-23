<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Description of VersionForm
 *
 * @author sebbar
 */
class VersionForm extends Form {
    
    public function __construct() {
        parent::__construct('version');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new ClassMethods());
        
        $element = new \Zend\Form\Element\Text('version');
        $element->setLabel('Version : ');
        $this->add($element);
                
        $element = new \Zend\Form\Element\Text('versionCommentaire');
        $element->setLabel('Commentaire : ');
        $this->add($element);
        
//        $element = new \Zend\Form\Element\DateTime('versionDate');
//        $element->setLabel('Date de la version (ex. 2015/09/25) : ');
//        $element->setFormat('Y-m-d');
//        $element->setValue(date('Y-m-d'));
//        $this->add($element);        
    }
        
}
