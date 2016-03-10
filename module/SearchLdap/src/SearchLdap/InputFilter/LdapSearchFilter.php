<?php

namespace SearchLdap\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

/**
 * Description of LdapSearchFilter
 *
 * @author mdjimbi
 */
class LdapSearchFilter extends InputFilter
{

    public function __construct()
    {
        $input = new Input('searchValue');

        $filter = new StringTrim();
        $input->getFilterChain()->attach($filter);

        $filter = new StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new StringLength();
        $validator->setMin(3);
        $input->getValidatorChain()->attach($validator);

        $validator = new NotEmpty();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);
    }
}
