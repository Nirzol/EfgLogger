<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class ListForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('list');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'listLibelle',
            'options' => array(
                'label' => 'Label :',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkListType',
            'attributes' => array(
                'id' => 'selectListType',
            ),
            'options' => array(
                'label' => 'Type de list : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntListtype',
                'property' => 'listtypeLibelle',
                'is_method' => true,
            ),
        ));
    }
}
