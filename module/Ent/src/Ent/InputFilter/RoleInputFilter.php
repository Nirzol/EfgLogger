<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class RoleInputFilter extends InputFilter //implements \Zend\Filter\FilterInterface
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'children',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        $this->add(array(
            'name' => 'permissions',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name' => 'name',
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
                        'max' => 48,
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

    public function appendEditValidator($id)
    {
        $this->add(
                array(
                    'name' => 'name',
                    'validators' => array(
                        array(
                            'name' => 'Ent\Validator\NoOtherEntityExists',
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntHierarchicalRole'),
                                'fields' => 'name',
                                'id' => $id, //
                                'id_getter' => 'getId', //getter for ID
                                'messages' => array(
                                    'objectFound' => 'This role already exists in database.',
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
                    'name' => 'name', //unique field name
                    'validators' => array(
                        array(
                            'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntHierarchicalRole'),
                                'fields' => 'name',
                                'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This role already exists in database.'),
                            ),
                        ),
                    )
                )
        );
        return $this;
    }

}
