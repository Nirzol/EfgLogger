<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Ent\Entity\EntService;
use Zend\Form\Form;

/**
 * Description of ProfileForm
 *
 * @author sebbar
 */
class ProfileForm extends Form
{

    protected $entityManager;

//    /**
//     *
//     * @var Fieldset\ServiceFieldset
//     */
//    protected $serviceFieldset;

    public function __construct(EntityManager $entityManager) //Fieldset\ServiceFieldset $serviceFieldset
    {
        parent::__construct('profile');

        $this->entityManager = $entityManager;
//        $this->serviceFieldset = $serviceFieldset;

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

        $this->add(array(
            'type' => '\DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'fkPsService',
            'attributes' => array(
                'id' => 'selectPrefAttribute',
//                'data-toggle'=>'modal',
//                'data-target'=>'#serviceId' . $service->getServiceId(),
            ),
            'options' => array(
                'label' => 'Services : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntService',
                'property' => 'serviceName',
                'is_method' => true,
            ),
        ));

        $attributes = $this->entityManager->getRepository('\Ent\Entity\EntAttribute')->findAll();
        $services = $this->entityManager->getRepository('\Ent\Entity\EntService')->findAll();

        /* @var $service EntService */
        foreach ($services as $service) {
            foreach ($attributes as $attribute) {
                $this->add(array(
                    'name' => 'serviceAttributes[' . $service->getServiceId() . '][' . $attribute->getAttributeId() . ']',
                    'options' => array(
                        'label' => $attribute->getAttributeName(),
                    ),
                    'attributes' => array(
                        'type' => 'text',
                        'id' => $attribute->getAttributeName(),
                    ),
                ));
            }
        }

//        $this->serviceFieldset->setName('services3');
//        $this->serviceFieldset->setLabel('Service of the profile');
//        $this->add($this->serviceFieldset);
//
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Collection',
//            'name' => 'services2',
//            'options' => array(
//                'label' => 'Please choose services for this profile',
//                'count' => 2,
//                'should_create_template' => true,
//                'allow_add' => true,
//                'target_element' => $this->serviceFieldset,
//            ),
//        ));
        //Fieldset des services avec à l'intérieur un fieldset des attributs
    }

}
