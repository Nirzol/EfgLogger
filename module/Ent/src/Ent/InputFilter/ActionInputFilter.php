<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class ActionInputFilter extends InputFilter
{
    public function __construct() {
        // Filtre pour actionName
        $input = new \Zend\InputFilter\Input('actionName');
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
        
        // Filtre pour actionLibelle
        $input = new \Zend\InputFilter\Input('actionLibelle');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $validator->setEncoding('UTF-8');
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        
        // Filtre pour actionDescription
        $input = new \Zend\InputFilter\Input('actionDescription');
        $input->setRequired(false);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $this->add($input);
    }
}
