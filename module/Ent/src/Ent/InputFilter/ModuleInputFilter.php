<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class ModuleInputFilter extends InputFilter {
    
    public function __construct() {
        // Filtre pour moduleName
        $input = new \Zend\InputFilter\Input('moduleName');
        $input->setRequired(true);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        
        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        // Filtre pour moduleLibelle
        $input = new \Zend\InputFilter\Input('moduleLibelle');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        
        // Filtre pour moduleDescription
        $input = new \Zend\InputFilter\Input('moduleDescription');
        $input->setRequired(false);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $this->add($input);
        
        
        // Filtre pour moduleLastUpdate
//        $input = new \Zend\InputFilter\Input('moduleLastUpdate');
//        $input->setRequired(true);
//        
//        $filter = new \Zend\Filter\StringTrim();
//        $input->getFilterChain()->attach($filter);
//        
//        $filter = new \Zend\Filter\StripTags();
//        $input->getFilterChain()->attach($filter);
//        
//        $validator = new \Zend\Validator\Date('moduleLastUpdate');
//        $validator->setFormat('Y-m-d');
//        $input->getFilterChain()->attach($validator);
//        
//        $this->add($input);
    }
    
}
