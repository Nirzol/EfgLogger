<?php

namespace Ent\Service;

use Ent\Entity\EntService;
use Zend\Form\Form;

/**
 *
 * @author fandria
 */
interface ServiceServiceInterface {
    public function getAll();
    public function getById($id, $form = null);
    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntService $service = null);
    public function delete($id);
}
