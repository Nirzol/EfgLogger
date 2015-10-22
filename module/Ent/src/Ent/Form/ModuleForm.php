<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class ModuleForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('module');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'moduleName',
            'options' => array(
                'label' => 'Nom du module : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'moduleLibelle',
            'options' => array(
                'label' => 'Libellé du module : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'moduleDescription',
            'options' => array(
                'label' => 'Description du module : ',
            ),
            'attributes' => array(
                'type' => 'textarea',
            ),
        ));
    }

}
