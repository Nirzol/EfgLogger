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
    }

}
