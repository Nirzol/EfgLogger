<?php

namespace Ent\Service;

use Zend\Form\Form;

interface PreferenceServiceInterface 
{
    public function getAll();
    
    public function getById($id);
    
    public function insert(Form $form, $dataAssoc);
    
    public function udpate($id, Form $form, $dataAssoc);
    
    public function delete($id);
}
