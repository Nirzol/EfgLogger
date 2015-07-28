<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class PreferenceInputFilter extends InputFilter
{
    public function __construct() {
        $input = new \Zend\InputFilter\Input('prefAttribute');
        $input->setRequired(true);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('fkPrefUser');
        $input->setRequired(false);
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('fkPrefService');
        $input->setRequired(false);
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('fkPrefStatus');
        $input->setRequired(false);
        $this->add($input);
        
        $input = new \Zend\InputFilter\Input('fkPrefProfile');
        $input->setRequired(false);
        $this->add($input);
    }
}
