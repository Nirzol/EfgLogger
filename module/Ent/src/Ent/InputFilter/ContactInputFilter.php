<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of ContactInputFilter
 *
 * @author fandria
 */
class ContactInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'contactName',
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
                        'max' => 200,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'contactLibelle',
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
                        'max' => 200,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'contactDescription',
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
            'name' => 'contactService',
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
                        'max' => 200,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'contactMailto',
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
                        'max' => 254,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));
    }

}
