<?php

namespace Ent\InputFilter;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Validator\NoObjectExists;
use Zend\InputFilter\InputFilter;

/**
 * Description of ServiceInputFilter
 *
 * @author fandria
 */
class ServiceInputFilter extends InputFilter
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'serviceName',
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

        $this->add(array(
            'name' => 'serviceLibelle',
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
//                array(
//                    'name' => 'NotEmpty',
//                ),
            ),
        ));

        $this->add(array(
            'name' => 'serviceDescription',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
//                array(
//                    'name' => 'NotEmpty',
//                ),
            ),
        ));

        $this->add(array(
            'name' => 'fkSaAttribute',
            'required' => false,
            'filters' => array(
            ),
            'validators' => array(
            ),
        ));

        $attributes = $this->entityManager->getRepository('\Ent\Entity\EntAttribute')->findAll();
        foreach ($attributes as $attribute) {
            $this->add(array(
                'name' => 'serviceAttributes[' . $attribute->getAttributeId() . ']',
                'required' => false,
                'filters' => array(
                ),
                'validators' => array(
                ),
            ));
        }

//        $this->add(array(
//            'name' => 'fkCsContact',
//            'required' => false,
//        ));
//        $attributes = $this->entityManager->getRepository('\Ent\Entity\EntAttribute')->findAll();
//        foreach ($attributes as $attribute) {
//            $this->add(array(
//                'name' => 'serviceAttributes['.$attribute->getAttributeId().']',
//                'required' => false,
//                'filters' => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name' => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min' => 3,
//                            'max' => 250,
//                        ),
//                    ),
//                ),
//            ));
//        }
    }

    public function appendEditValidator($id)
    {
        $this->add(
            array(
                'name' => 'serviceName',
                'validators' => array(
                    array(
                        'name' => 'Ent\Validator\NoOtherEntityExists',
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntService'),
                            'fields' => 'serviceName',
                            'id' => $id, //
                            'id_getter' => 'getServiceId', //getter for ID
                            'messages' => array(
                                'objectFound' => 'This service already exists in database.',
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
                'name' => 'serviceName', //unique field name
                'validators' => array(
                    array(
                        'name' => '\DoctrineModule\Validator\NoObjectExists', //use namespace
                        'options' => array(
                            'object_repository' => $this->entityManager->getRepository('Ent\Entity\EntService'),
                            'fields' => 'serviceName',
                            'messages' => array(NoObjectExists::ERROR_OBJECT_FOUND => 'This service already exists in database.'),
                        ),
                    ),
                )
            )
        );
        return $this;
    }
}
