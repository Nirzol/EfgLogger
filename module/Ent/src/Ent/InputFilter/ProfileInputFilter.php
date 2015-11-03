<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class ProfileInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour le profileName
        $this->add(array(
            'name' => 'profileName',
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

        // Filtre pour le profileLdap
        $this->add(array(
            'name' => 'profileLdap',
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

        // Filtre pour profileLibelle
        $this->add(array(
            'name' => 'profileLibelle',
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

        // Filtre pour profileDescription
        $this->add(array(
            'name' => 'profileDescription',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ));
        
        $this->add(array(
            'name' => 'fkPsService',
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
                    'name' => 'profileName',
                    'validators' => array(
                        array(
                            'name' => 'Ent\Validator\NoOtherEntityExists',
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntProfile'),
                                'fields' => 'profileName',
                                'id' => $id, //
                                'id_getter' => 'getProfileId', //getter for ID
                                'messages' => array(
                                    'objectFound' => 'This profile already exists in database.',
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
                    'name' => 'profileName', //unique field name
                    'validators' => array(
                        array(
                            'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                            'options' => array(
                                'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntProfile'),
                                'fields' => 'profileName',
                                'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This profile already exists in database.'),
                            ),
                        ),
                    )
                )
        );
        return $this;
    }

}
