<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class StatusInputFilter extends InputFilter
{
    public function __construct() {
        // Filtre pour statusName
        $input = new \Zend\InputFilter\Input('statusName');
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
        
        // Filtre pour statusLibelle
        $input = new \Zend\InputFilter\Input('statusLibelle');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        
        // Filtre pour statusDescription
        $input = new \Zend\InputFilter\Input('statusDescription');
        $input->setRequired(false);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $this->add($input);
    }
}
