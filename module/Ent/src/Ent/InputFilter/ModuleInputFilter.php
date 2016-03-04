<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class ModuleInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour moduleName
        $this->add(array(
            'name' => 'moduleName',
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
                        'max' => 250,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
            ),
        ));

        // Filtre pour moduleLibelle
        $this->add(array(
            'name' => 'moduleLibelle',
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
                        'max' => 250,
                    ),
                ),
            ),
        ));

        // Filtre pour moduleDescription
        $this->add(array(
            'name' => 'moduleDescription',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ));
    }

    public function appendEditValidator($id)
    {
        $this->add(
            array(
                'name' => 'moduleName',
                'validators' => array(
                    array(
                        'name' => 'Ent\Validator\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntModule'),
                            'fields' => 'moduleName',
                            'id' => $id, //
                            'id_getter' => 'getModuleId', //getter for ID
                            'messages' => array(
                                'objectFound' => 'This module already exists in database.',
                            ),
                        ),
                    ),
                )
            )
        );
        return $this;
    }

    public function appendAddValidator()
    {
        $this->add(
            array(
                'name' => 'moduleName', //unique field name
                'validators' => array(
                    array(
                        'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntModule'),
                            'fields' => 'moduleName',
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This module already exists in database.'),
                        ),
                    ),
                )
            )
        );
        return $this;
    }
}
