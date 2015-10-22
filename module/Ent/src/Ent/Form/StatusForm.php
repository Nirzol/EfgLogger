<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class StatusForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('status');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'statusName',
            'options' => array(
                'label' => 'Nom du status : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'statusLibelle',
            'options' => array(
                'label' => 'Libellé du status : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'statusDescription',
            'options' => array(
                'label' => 'Description du status : ',
            ),
            'attributes' => array(
                'type' => 'textarea',
            ),
        ));
    }

}
