<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Service;

use Zend\Form\Form;

/**
 *
 * @author sebbar
 */
interface GenericEntityServiceInterface {
    
    public function getAll();
    
    public function getById($id);
    
    public function insert(Form $form, $dataAssoc);
    
    public function update($id, Form $form, $dataAssoc);
    
    public function delete($id);
}
