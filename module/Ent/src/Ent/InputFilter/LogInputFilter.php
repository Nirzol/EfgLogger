<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use Zend\InputFilter\InputFilter;

class LogInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour logLogin
        $this->add(array(
            'name' => 'logLogin',
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

        // Filtre pour logOnline
        $this->add(array(
            'name' => 'logOnline',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour logOffline
        $this->add(array(
            'name' => 'logOffline',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour logSession
        $this->add(array(
            'name' => 'logSession',
            'required' => false,
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
            ),
        ));

        // Filtre pour logIp
        $this->add(array(
            'name' => 'logIp',
            'required' => false,
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
                        'max' => 15,
                    ),
                ),
            ),
        ));

        // Filtre pour logUseragent
        $this->add(array(
            'name' => 'logUseragent',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour fkLogUser
        $this->add(array(
            'name' => 'fkLogUser',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour fkLogAction
        $this->add(array(
            'name' => 'fkLogAction',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour fkLogModule
        $this->add(array(
            'name' => 'fkLogModule',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }

}
