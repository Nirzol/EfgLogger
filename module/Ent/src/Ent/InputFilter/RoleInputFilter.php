<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class RoleInputFilter extends InputFilter //implements \Zend\Filter\FilterInterface
{

    public function __construct()
    {
        
        $this->add(array(
            'name' => 'roleName',
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
        
                        
//        $this->add(array(
//            'name' => 'userLogin',
//            'required' => true,
//            'filters' => array(
//                array('name' => 'StripTags'),
//                array('name' => 'StringTrim'),
//            ),
//            'validators' => array(
//                array(
//                    'name' => 'StringLength',
//                    'options' => array(
//                        'encoding' => 'UTF-8',
//                        'min' => 3,
//                        'max' => 80,
//                    ),
//                ),
//                array(
//                    'name' => 'NotEmpty',
//                ),
//            ),
//        ));
//
//        $this->add(array(
//            'name' => 'userStatus',
//            'required' => true,
//            'filters' => array(
//            ),
//            'validators' => array(
//            ),
//        ));
    }

//    public function filter($value)
//    {
//        
//    }

}
