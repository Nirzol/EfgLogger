<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class UserForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('user');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'userLogin',
            'options' => array(
                'label' => 'Login :',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'userStatus',
            'options' => array(
                'label' => 'Status : ',
                'checked_value' => '1',
                'unchecked_value' => '0',
            ),
            'attributes' => array(
                'value' => '1',
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkUrRole',
            'attributes' => array(
                'id' => 'selectUserRole',
            ),
            'options' => array(
                'label' => 'Rôle : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntHierarchicalRole',
                'property' => 'name',
                'is_method' => true,
//                'find_method' => array(
//                    'name' => 'getRoleLibelle',
//                ),
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkUpProfile',
            'attributes' => array(
                'id' => 'selectUserProfile',
            ),
            'options' => array(
                'label' => 'Profil : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntProfile',
                'property' => 'profileName',
                'label_generator' => function ($targetEntity) {
                    return $targetEntity->getProfileLibelle() . ' --- (' . $targetEntity->getProfileName() . ')';
                },
                'is_method' => true,
            ),
        ));

        $this->add(array(
            'type' => '\Zend\Form\Element\DateTime',
            'name' => 'userLastConnection',
            'options' => array(
                'label' => 'Last connection',
                'format' => 'Y-m-d H:i:s'
            ),
            'attributes' => array(
//                'min' => '2010-01-01T00:00:00Z',
//                'max' => '2020-01-01T00:00:00Z',
                'step' => 'any', // minutes; default step interval is 1 min
            )
        ));
    }

}
