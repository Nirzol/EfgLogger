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
 * Description of ProfileForm
 *
 * @author sebbar
 */
class ProfileForm extends Form
{
    public function __construct() {
        parent::__construct('profile');
        
        // Gestion de l'arrayCopy
        $this->setHydrator(new ClassMethods());
        
        $element = new \Zend\Form\Element\Text('profileLdap');
        $element->setLabel('Profile Ldap : ');
        $this->add($element);
                
        $element = new \Zend\Form\Element\Text('profileName');
        $element->setLabel('Nom du profile : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Text('profileLibelle');
        $element->setLabel('Libellé du profile : ');
        $this->add($element);
        
        $element = new \Zend\Form\Element\Textarea('profileDescription');
        $element->setLabel('Description du profile : ');
        $this->add($element);
        
    }
        
        
}
