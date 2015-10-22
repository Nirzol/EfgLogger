<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class PreferenceForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('preference');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'prefAttribute',
            'options' => array(
                'label' => 'Préférence de l\'attribut : ',
            ),
            'attributes' => array(
                'type' => 'textarea',
                'placeholder' => 'Un JSON please :-)',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkPrefUser',
            'attributes' => array(
                'id' => 'selectPreferenceUser',
            ),
            'options' => array(
                'label' => 'User : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntUser',
                'empty_option' => '---SELECT USER---',
                'property' => 'userLogin',
                'is_method' => true,
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkPrefService',
            'attributes' => array(
                'id' => 'selectPreferenceService',
            ),
            'options' => array(
                'label' => 'Service : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntService',
                'empty_option' => '---SELECT SERVICE---',
                'property' => 'serviceName',
                'is_method' => true,
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkPrefStatus',
            'attributes' => array(
                'id' => 'selectPreferenceStatus',
            ),
            'options' => array(
                'label' => 'Status : ',
                'object_manager' => $this->entityManager,
                'empty_option' => '---SELECT STATUS---',
                'target_class' => 'Ent\Entity\EntStatus',
                'property' => 'statusName',
                'is_method' => true,
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'fkPrefProfile',
            'attributes' => array(
                'id' => 'selectPreferenceProfile',
            ),
            'options' => array(
                'label' => 'Profil : ',
                'object_manager' => $this->entityManager,
                'empty_option' => '---SELECT PROFILE---',
                'target_class' => 'Ent\Entity\EntProfile',
                'property' => 'profileName',
                'is_method' => true,
            ),
        ));
    }

}
