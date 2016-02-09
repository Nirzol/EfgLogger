<?php

namespace SearchLdap\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of LdapSearchFilter
 *
 * @author mdjimbi
 */

class LdapSearchFilter extends InputFilter {
    public function __construct() {
        $input = new \Zend\InputFilter\Input('searchValue');

        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);

        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);

        $validator = new \Zend\Validator\StringLength();
        $validator->setMin(3);
        $input->getValidatorChain()->attach($validator);

        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);

        $this->add($input);
    }
}
