<?php

namespace Ent\Service;

use Ent\Entity\EntPermission;
use Zend\Form\Form;

interface PermissionServiceInterface
{
    public function getAll();
    public function getAllRest();
    public function getById($id, $form = null);
//    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntPermission $permission = null);
    public function delete($id);  
}
