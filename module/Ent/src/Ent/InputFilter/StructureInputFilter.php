<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of StructureInputFilter
 *
 * @author fandria
 */
class StructureInputFilter extends InputFilter{
    public function __construct()
    {
        
        $this->add(array(
            'name' => 'structureId',
            'required' => true,
            'filters' => array(
                array('name' => 'Int')
            ),
            'validators' => array(
                array(
                    'name' => 'Digits',
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'structureFatherid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int')
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'structureType',
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
                        'max' => 45,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'structureCode',
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
                        'max' => 45,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'structureLibelle',
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
    }
}
