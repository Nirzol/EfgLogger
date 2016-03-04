<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

class AttributeInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        // Filtre pour attributeName
        $this->add(array(
            'name' => 'attributeName',
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

        // Filtre pour attributeLibelle
        $this->add(array(
            'name' => 'attributeLibelle',
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

        // Filtre pour attributeDescription
        $this->add(array(
            'name' => 'attributeDescription',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            ),
        ));

        // Filtre pour attributeList
        $this->add(array(
            'name' => 'fkAttributeListtype',
            'required' => false,
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
                'name' => 'attributeName',
                'validators' => array(
                    array(
                        'name' => 'Ent\Validator\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntAttribute'),
                            'fields' => 'attributeName',
                            'id' => $id, //
                            'id_getter' => 'getAttributeId', //getter for ID
                            'messages' => array(
                                'objectFound' => 'This attribute already exists in database.',
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
                'name' => 'attributeName', //unique field name
                'validators' => array(
                    array(
                        'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntAttribute'),
                            'fields' => 'attributeName',
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This attribute already exists in database.'),
                        ),
                    ),
                )
            )
        );
        return $this;
    }
}
