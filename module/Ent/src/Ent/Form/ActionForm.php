<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class ActionForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('action');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'actionName',
            'options' => array(
                'label' => 'Nom de l\'action : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'actionLibelle',
            'options' => array(
                'label' => 'Libellé de l\'action  : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'actionDescription',
            'options' => array(
                'label' => 'Description de l\'action  : ',
            ),
            'attributes' => array(
                'type' => 'textarea',
            ),
        ));
    }

}
