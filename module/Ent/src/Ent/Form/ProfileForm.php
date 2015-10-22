<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Description of ProfileForm
 *
 * @author sebbar
 */
class ProfileForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('profile');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'profileLdap',
            'options' => array(
                'label' => 'Profile Ldap : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'profileName',
            'options' => array(
                'label' => 'Nom du profile : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'profileLibelle',
            'options' => array(
                'label' => 'Libellé du profile : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'profileDescription',
            'options' => array(
                'label' => 'Description du profile : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));
    }

}
