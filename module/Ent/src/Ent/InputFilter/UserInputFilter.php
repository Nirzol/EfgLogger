<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class UserInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'userLogin',
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

        $this->add(array(
            'name' => 'userStatus',
            'required' => true,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));
    }

    public function appendEditValidator($id)
    {
        $this->add(
                array(
                    'name' => 'userLogin',
                    'validators' => array(
                        array(
                            'name' => 'Ent\Validator\NoOtherEntityExists',
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntUser'),
                                'fields' => 'userLogin',
                                'id' => $id, //
                                'id_getter' => 'getUserId', //getter for ID
                                'messages' => array(
                                    'objectFound' => 'This user already exists in database.',
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
                    'name' => 'userLogin', //unique field name
                    'validators' => array(
                        array(
                            'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntUser'),
                                'fields' => 'userLogin',
                                'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This user already exists in database.'),
                            ),
                        ),
                    )
                )
        );
        return $this;
    }

}
