<?php

namespace Ent\Form;

use Zend\Form\Form;

class ListtypeForm extends Form
{

    public function __construct()
    {
        parent::__construct('listtype');

        $this->add(array(
            'name' => 'listtypeLibelle',
            'options' => array(
                'label' => 'Label :',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'listtypeName',
            'options' => array(
                'label' => 'Name :',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'listtypeDescription',
            'options' => array(
                'label' => 'Description :',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
    }

}
