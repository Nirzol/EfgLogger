<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

class AttributeInputFilter extends InputFilter
{
    public function __construct() {
        // Filtre pour attributeName
        $input = new \Zend\InputFilter\Input('attributeName');
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
        
        // Filtre pour attributeLibelle
        $input = new \Zend\InputFilter\Input('attributeLibelle');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        
        $this->add($input);
        
        
        // Filtre pour attributeDescription
        $input = new \Zend\InputFilter\Input('attributeDescription');
        $input->setRequired(false);
        
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        
        $this->add($input);
    }
}
