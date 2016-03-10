<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of HelpRequestInputFilter
 *
 * @author mdjimbi
 */
class HelpRequestInputFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name' => 'contactDescription',
            'required' => true,
        ));

        $input = new \Zend\InputFilter\Input('message');

        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);

        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new \Zend\Validator\StringLength(array('min' => 1, 'max' => 500));
        //$validator->setMax(255);
        $input->getValidatorChain()->attach($validator);

        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);

        $fileInput = new \Zend\InputFilter\FileInput('image-file');
        $fileInput->setRequired(false);

        $validatorSize = new \Zend\Validator\File\Size(array('min' => 1, 'max' => 2000000));
        $fileInput->getValidatorChain()->attach($validatorSize);

        $validatorType = new \Zend\Validator\File\MimeType(array(
            'image/png',
            'image/jpeg',
            'text/plain',
            'application/pdf',
            'application/vnd.ms-powerpoint'));
        $fileInput->getValidatorChain()->attach($validatorType);

        $this->add($fileInput);

        $input = new \Zend\InputFilter\Input('email');
        $input->setRequired(false);

        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);

        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new \Zend\Validator\EmailAddress();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);
    }
}
