<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Element\Email;
use Zend\Form\Element\File;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

/**
 * Description of HelpRequestForm
 *
 * @author mdjimbi
 */
class HelpRequestForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('contact');

        $this->entityManager = $entityManager;

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'contactDescription',
            'options' => array(
                'label' => 'Votre problème concerne : ',
                'object_manager' => $this->entityManager,
                'target_class' => 'Ent\Entity\EntContact',
                'empty_option' => '---Sélectionnez un type de problème---',
                'property' => 'contactDescription',
                'is_method' => true,
            ),
        ));

        $element = new Textarea('message');
        $element->setLabel('Votre message');
        $this->add($element);

        // File input
        $file = new File('image-file');
        $file->setLabel('Copie d\'écran');
        $file->setAttribute('id', 'image-file');
        $file->setAttribute('multiple', true);
        $this->add($file);

        $element = new Email('email');
        $element->setLabel('Adresse e-mail alternative');
        $this->add($element);
    }

}
