<?php

namespace Ent\Form;

use DoctrineModule\Validator\NoObjectExists as NoObjectExistsValidator;
use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class PermissionForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('permission');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name :',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
    }


}
