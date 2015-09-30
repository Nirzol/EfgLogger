<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of ServiceAttributeInputFilter
 *
 * @author fandria
 */
class ServiceAttributeInputFilter extends InputFilter {
    public function __construct()
    {
        $this->add(array(
            'name' => 'serviceAttributeValue',
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
            'name' => 'fkSaServiceSA',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'fkSaAttributeSA',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }
}
