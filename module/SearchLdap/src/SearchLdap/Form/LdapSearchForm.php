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
    }
}
