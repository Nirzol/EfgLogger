<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class StatusInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour statusName
        $this->add(array(
            'name' => 'statusName',
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

        // Filtre pour statusLibelle
        $this->add(array(
            'name' => 'statusLibelle',
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

        // Filtre pour statusDescription
        $this->add(array(
            'name' => 'statusDescription',
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
                'name' => 'statusName',
                'validators' => array(
                    array(
                        'name' => 'Ent\Validator\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntStatus'),
                            'fields' => 'statusName',
                            'id' => $id, //
                            'id_getter' => 'getStatusId', //getter for ID
                            'messages' => array(
                                'objectFound' => 'This status already exists in database.',
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
                'name' => 'statusName', //unique field name
                'validators' => array(
                    array(
                        'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntStatus'),
                            'fields' => 'statusName',
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This status already exists in database.'),
                        ),
                    ),
                )
            )
        );
        return $this;
    }
}
