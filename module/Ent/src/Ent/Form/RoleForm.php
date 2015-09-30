<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class RoleForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('role');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Nom du role : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'permissions',
            'attributes' => array(
                'id' => 'selectChildRole',
            ),
            'options' => array(
                'label' => 'Permissions : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntPermission',
                'property' => 'name',
            ),
        ));
    }

    public function initParams($id)
    {

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'children',
            'attributes' => array(
                'id' => 'selectChildRole',
            ),
            'options' => array(
                'label' => 'Rôle enfant : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntHierarchicalRole',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findAllExceptOne',
                    'params' => array(
                        'roleID' => $id,
                    ),
                ),
            ),
        ));
    }

}
