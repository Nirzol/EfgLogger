<?php

namespace Ent\Service;

use Ent\Entity\EntServiceAttribute;
use Zend\Form\Form;
/**
 *
 * @author fandria
 */
interface ServiceAttributeServiceInterface {
    public function getAll();
    public function getById($id, $form = null);
    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntServiceAttribute $serviceAttribute = null);
    public function delete($id);
}
