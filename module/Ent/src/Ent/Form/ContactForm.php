<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Description of ContactForm
 *
 * @author fandria
 */
class ContactForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('contact');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'contactName',
            'options' => array(
                'label' => 'Name : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'contactLibelle',
            'options' => array(
                'label' => 'Libelle : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'contactDescription',
            'options' => array(
                'label' => 'Description : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'contactService',
            'options' => array(
                'label' => 'Service : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'contactMailto',
            'options' => array(
                'label' => 'Mailto : ',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectRadio',
            'name' => 'fkContactStructure',
            'attributes' => array(
                'id' => 'selectContactStructure'
            ),
            'options' => array(
                'label' => 'Structure : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntStructure',
                'property' => 'structureLibelle',
                'is_method' => true
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkCsService',
            'attributes' => array(
                'id' => 'selectContactService'
            ),
            'options' => array(
                'label' => 'Service : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntService',
                'property' => 'serviceName',
                'is_method' => true
            ),
        ));

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkUcUser',
            'attributes' => array(
                'id' => 'selectContactUser'
            ),
            'options' => array(
                'label' => 'Login : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntUser',
                'property' => 'userLogin',
                'is_method' => true
            ),
        ));
    }

}
