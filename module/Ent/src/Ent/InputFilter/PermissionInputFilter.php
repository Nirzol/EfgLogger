<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class PermissionInputFilter extends InputFilter
{

//    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

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
                        'max' => 128,
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                ),
//                array(
//                    'name' => '\DoctrineModule\Validator\NoObjectExists',
//                    'options' => array(
//                        'object_repository' => $entityManager->getRepository('Ent\Entity\EntPermission'),
//                        'fields' => 'name',
//                        'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => "This object with code already exists in database."),
//                    ),
//                ),
            ),
        ));
    }

    public function appendEditValidator($id)
    {
        $this->add(
//            $this->getFactory()->createInput(
                array(
                    'name' => 'name',
                    'validators' => array(
                        array(
                            'name' => 'Ent\Validator\NoOtherEntityExists',
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntPermission'),
                                'fields' => 'name',
                                'id' => $id, //
                                'id_getter' => 'getId', //getter for ID
                                'messages' => array(
                                    'objectFound' => 'This permission already exists in database.',
                                ),
                            ),
                        ),
                    )
                )
//                )
        );
        return $this;
    }

    public function appendAddValidator()
    {
        $this->add(
//                $this->getFactory()->createInput(
                array(
                    'name' => 'name', //unique field name
                    'validators' => array(
                        array(
                            'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntPermission'),
                                'fields' => 'name',
                                'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This permission already exists in database.'),
                            ),
                        ),
                    )
                )
//                        )
        );
        return $this;
    }

}
