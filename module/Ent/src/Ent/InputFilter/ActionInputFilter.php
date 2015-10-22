<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class ActionInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour actionName
        $this->add(array(
            'name' => 'actionName',
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

        // Filtre pour actionLibelle
        $this->add(array(
            'name' => 'actionLibelle',
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

        // Filtre pour actionDescription
        $this->add(array(
            'name' => 'actionDescription',
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
                    'name' => 'actionName',
                    'validators' => array(
                        array(
                            'name' => 'Ent\Validator\NoOtherEntityExists',
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntAction'),
                                'fields' => 'actionName',
                                'id' => $id, //
                                'id_getter' => 'getActionId', //getter for ID
                                'messages' => array(
                                    'objectFound' => 'This action already exists in database.',
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
                    'name' => 'actionName', //unique field name
                    'validators' => array(
                        array(
                            'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntAction'),
                                'fields' => 'actionName',
                                'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This action already exists in database.'),
                            ),
                        ),
                    )
                )
        );
        return $this;
    }

}
