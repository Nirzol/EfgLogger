<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class ListInputFilter extends InputFilter
{

    public function __construct()
    {

        $this->add(array(
            'name' => 'listLibelle',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 80,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'fkListType',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }
}
