<?php

namespace Ent\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Description of StructureForm
 *
 * @author fandria
 */
class StructureForm extends Form
{

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('structure');

        $this->entityManager = $entityManager;

        $this->add(array(
            'name' => 'structureId',
            'attributes' => array(
                'type' => 'number',
            ),
        ));

        $this->add(array(
            'name' => 'structureFatherid',
            'attributes' => array(
                'type' => 'number',
            ),
        ));

        $this->add(array(
            'name' => 'structureType',
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'structureCode',
            'attributes' => array(
                'type' => 'text',
            ),
        ));

        $this->add(array(
            'name' => 'structureLibelle',
            'attributes' => array(
                'type' => 'text',
            ),
        ));
    }

}
