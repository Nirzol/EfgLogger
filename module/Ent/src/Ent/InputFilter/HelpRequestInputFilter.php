<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of HelpRequestInputFilter
 *
 * @author mdjimbi
 */
class HelpRequestInputFilter extends InputFilter {

    public function __construct() {
        $this->add(array(
            'name' => 'contactDescription',
            'required' => true,
        ));

        $input = new \Zend\InputFilter\Input('message');

        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);

        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(255);
        $input->getValidatorChain()->attach($validator);

        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);
        
        $fileInput = new \Zend\InputFilter\FileInput();
        $fileInput->setRequired(false);
        
        $fileInput->getValidatorChain()
                ->attachByName('file-size', array('max' => 2000000))
                ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/jpg'));
    }

}
