<?php

namespace Ent\Service;

use Ent\Entity\EntUser;
use Zend\Form\Form;

interface UserServiceInterface
{
    public function getAll();
    public function getAllRest();
    public function getById($id, $form = null);
//    public function insert(Form $form, $dataAssoc);
    public function save(Form $form, $dataAssoc, EntUser $user = null);
    public function delete($id);  
}
