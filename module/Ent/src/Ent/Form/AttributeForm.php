<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class AttributeForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('attribute');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'attributeName',
            'options' => array(
                'label' => 'Nom de l\'attribut : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'attributeLibelle',
            'options' => array(
                'label' => 'Libellé de l\'attribut : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'attributeDescription',
            'options' => array(
                'label' => 'Description de l\'attribut :',
            ),
            'attributes' => array(
                'type' => 'textarea',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkAttributeListtype',
            'attributes' => array(
                'id' => 'selectAttributeListtype',
            ),
            'options' => array(
                'label' => 'Mettre une catégorie si l\'attrbiut doit être une liste déroulante  : ',
                'object_manager' => $this->entityManager,
                'empty_option' => '---Pas de liste déroulante---',
                'target_class' => 'Ent\Entity\EntListtype',
                'property' => 'listtypeLibelle',
                'is_method' => true,
            ),
        ));
    }

}
