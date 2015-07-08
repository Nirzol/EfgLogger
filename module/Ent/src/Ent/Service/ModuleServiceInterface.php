<?php

namespace Ent\Service;

use Zend\Form\Form;

interface ModuleServiceInterface 
{
    public function getAll();
    
    public function getById($id);
    
    public function insert(Form $form, $dataAssoc);
    
    public function update($id, Form $form, $dataAssoc);
    
    public function delete($id);
}
