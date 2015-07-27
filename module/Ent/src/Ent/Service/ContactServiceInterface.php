<?php

namespace Ent\Service;

use Ent\Entity\EntContact;
use Zend\Form\Form;

/**
 *
 * @author fandria
 */
interface ContactServiceInterface {
    public function getAll();
    public function getById($id, $form = null);
    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntContact $contact = null);
    public function delete($id);
}
