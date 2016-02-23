<?php

namespace SearchLdap\Form;

use Zend\Form\Form;

/**
 * Description of LdapSearchForm
 *
 * @author mdjimbi
 */

class LdapSearchForm extends Form {
    public function __construct($name = null) {
        parent::__construct('searchLdap');
        
        $this->add(array(
            'name' => 'searchValue',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nom, login, mail ou (filtre ldap) : ',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Chercher',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'userTypeStaff',
            'options' => array(
                'label' => 'Personnel : ',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'userTypeStudent',
            'options' => array(
                'label' => 'Etudiant : ',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            ),
        ));
    }
}
