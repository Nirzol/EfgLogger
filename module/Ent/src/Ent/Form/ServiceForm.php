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
        $listEntity = $this->entityManager->getRepository('\Ent\Entity\EntList');
        foreach ($attributes as $attribute) {
            if ($attribute->getFkAttributeListtype()) {
                $this->add(array(
                    'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                    'name' => 'serviceAttributes[' . $attribute->getAttributeId() . ']',
                    'attributes' => array(
                        'id' => $attribute->getAttributeName(),
                    ),
                    'options' => array(
                        'label' => $attribute->getAttributeName(),
                        'object_manager' => $this->entityManager,
                        'empty_option' => '---Pas de liste déroulante---',
                        'target_class' => 'Ent\Entity\EntList',
                        'property' => 'listLibelle',
//                        'option_attributes' => array(
//                            'value' => function (\Ent\Entity\EntList $listEntity) {
//                                return $listEntity->getListLibelle();
//                            }
//                        ),
                        'is_method' => true,
                        'find_method' => array(
                            'name' => 'findBy',
                            'params' => array(
                                'criteria' => array('fkListType' => 1),
                                // Use key 'orderBy' if using ORM
                                'orderBy' => array('listLibelle' => 'ASC'),
                            // Use key 'sort' if using ODM
//                                'sort' => array('lastname' => 'ASC')
                            ),
                        ),
                    ),
                ));
            } else {
                $this->add(array(
                    'name' => 'serviceAttributes[' . $attribute->getAttributeId() . ']',
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

}
