<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class ProfileInputFilter  extends InputFilter {
    
    public function __construct() {
        
        // Filtre pour le profileName
        $input = new \Zend\InputFilter\Input('profileName');
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

        // Filtre pour le profileLdap
        $input = new \Zend\InputFilter\Input('profileLdap');
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
        
        // Filtre pour profileLibelle
        $input = new \Zend\InputFilter\Input('profileLibelle');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        // Filtre pour profileDescription
        $input = new \Zend\InputFilter\Input('profileDescription');
        $input->setRequired(false);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $this->add($input);
    }
        
}
