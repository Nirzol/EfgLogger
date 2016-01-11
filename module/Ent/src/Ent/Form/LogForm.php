<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

class LogForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('log');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'logLogin',
            'options' => array(
                'label' => 'Login : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'type' => '\Zend\Form\Element\DateTime',
            'name' => 'logOnline',
            'options' => array(
                'label' => 'Log Online',
                'format' => 'Y-m-d H:i:s'
            ),
            'attributes' => array(
//                'min' => '2010-01-01T00:00:00Z',
//                'max' => '2020-01-01T00:00:00Z',
                'step' => 'any', // minutes; default step interval is 1 min
            )
        ));

        $this->add(array(
            'type' => '\Zend\Form\Element\DateTime',
            'name' => 'logOffline',
            'options' => array(
                'label' => 'Log Offline',
                'format' => 'Y-m-d H:i:s'
            ),
            'attributes' => array(
//                'min' => '2010-01-01T00:00:00Z',
//                'max' => '2020-01-01T00:00:00Z',
                'step' => 'any', // minutes; default step interval is 1 min
            )
        ));

        $this->add(array(
            'name' => 'logSession',
            'options' => array(
                'label' => 'Log Session : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'logIp',
            'options' => array(
                'label' => 'Log IP : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'logUseragent',
            'options' => array(
                'label' => 'Login : ',
            ),
            'attributes' => array(
                'type' => 'textarea',
            ),
        ));

        $this->add(array(
            'name' => 'fkLogUser',
            'options' => array(
                'label' => 'fkLogUser : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
//            'type' => '\Zend\Form\Element\Select',
////            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'fkLogUser',
//            'attributes' => array(
//                'id' => 'selectLogUser',
//            ),
//            'options' => array(
//                'label' => 'Log user : ',
////                'object_manager' => $this->entityManager,
////                'empty_option' => '---SELECT USER---',
////                'target_class' => 'Ent\Entity\EntUser',
////                'property' => 'userLogin',
////                'is_method' => true,
//            ),
        ));

        $this->add(array(
            'name' => 'fkLogAction',
            'options' => array(
                'label' => 'fkLogUser : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
//            'type' => '\Zend\Form\Element\Select',
////            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'fkLogAction',
//            'attributes' => array(
//                'id' => 'selectLogAction',
//            ),
//            'options' => array(
//                'label' => 'Log action : ',
//                'object_manager' => $this->entityManager,
//                'empty_option' => '---SELECT ACTION---',
//                'target_class' => 'Ent\Entity\EntAction',
//                'property' => 'actionName',
//                'is_method' => true,
//            ),
        ));

        $this->add(array(
            'name' => 'fkLogModule',
            'options' => array(
                'label' => 'fkLogModule : ',
            ),
            'attributes' => array(
                'type' => 'text',
            ),
//            'type' => '\Zend\Form\Element\Select',
////            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
//            'name' => 'fkLogModule',
//            'attributes' => array(
//                'id' => 'selectLogModule',
//            ),
//            'options' => array(
//                'label' => 'Log module : ',
////                'object_manager' => $this->entityManager,
////                'empty_option' => '---SELECT MODULE---',
////                'target_class' => 'Ent\Entity\EntModule',
////                'property' => 'moduleName',
////                'is_method' => true,
//            ),
        ));
    }

}
