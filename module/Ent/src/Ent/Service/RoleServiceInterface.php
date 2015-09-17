<?php

namespace Ent\Service;

use Ent\Entity\EntHierarchicalRole;
use Zend\Form\Form;

interface RoleServiceInterface
{
    public function getAll();
    public function getAllRest();
    public function getById($id, $form = null);
//    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntHierarchicalRole $role = null);
    public function delete($id);  
}
