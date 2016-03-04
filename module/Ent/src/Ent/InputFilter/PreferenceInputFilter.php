<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class PreferenceInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'prefAttribute',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'fkPrefUser',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'fkPrefService',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
        $this->add(array(
            'name' => 'fkPrefStatus',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $this->add(array(
            'name' => 'fkPrefProfile',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }
}
