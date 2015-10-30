<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Description of ServiceForm
 *
 * @author fandria
 */
class ServiceForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('service');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'serviceName',
            'options' => array(
                'label' => 'Name : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'serviceLibelle',
            'options' => array(
                'label' => 'Libelle : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'serviceDescription',
            'options' => array(
                'label' => 'Description : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

//        $this->add(array(
//            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
//            'name' => 'fkCsContact',
//            'attributes' => array(
//                'id' => 'selectServiceContact'
//            ),
//            'options' => array(
//                'label' => 'Contact : ',
//                'object_manager' => $this->entityManager,
//                'target_class' => 'Ent\Entity\EntContact',
//                'property' => 'contactName',
//                'is_method' => true
//            ),
//        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkSaAttribute',
            'attributes' => array(
                'id' => 'selectServiceAttribute'
            ),
            'options' => array(
                'label' => 'Attributs : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntAttribute',
                'property' => 'attributeName',
                'is_method' => true,
            ),
        ));


        $attributes = $this->entityManager->getRepository('\Ent\Entity\EntAttribute')->findAll();
        foreach ($attributes as $attribute) {
            $this->add(array(
                'name' => 'serviceAttributes['.$attribute->getAttributeId().']',
                'options' => array(
                    'label' => $attribute->getAttributeName(),
                ),
                'attributes' => array(
                    'type' => 'text',
                    'id' => $attribute->getAttributeName(),
                ),
            ));
        }
    }

}
