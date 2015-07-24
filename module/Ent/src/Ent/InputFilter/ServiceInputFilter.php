<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of ServiceInputFilter
 *
 * @author fandria
 */
class ServiceInputFilter extends InputFilter{
    public function __construct()
    {
        $this->add(array(
            'name' => 'serviceName',
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
                        'min' => 1,
                        'max' => 250,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'serviceLibelle',
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
                        'min' => 1,
                        'max' => 250,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'serviceDescription',
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
            'name' => 'fkCsContact',
            'required' => false,
        ));
    }
}
