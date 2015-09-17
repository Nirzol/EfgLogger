<?php

namespace Ent\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Description of VersionInputFilter
 *
 * @author sebbar
 */
class VersionInputFilter extends InputFilter {
    public function __construct() {
        
        // Filtre pour l'entite EntVersion
        
        // champ version
        $input = new \Zend\InputFilter\Input('version');
        $input->setRequired(true);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(64);
        $input->getValidatorChain()->attach($validator);
        $validator = new \Zend\Validator\NotEmpty();
        $input->getValidatorChain()->attach($validator);
        $this->add($input);

        // champ commentaire
        $input = new \Zend\InputFilter\Input('versionCommentaire');
        $input->setRequired(false);
        $filter = new \Zend\Filter\StringTrim();
        $input->getFilterChain()->attach($filter);        
        $filter = new \Zend\Filter\StripTags();
        $input->getFilterChain()->attach($filter);
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(250);
        $input->getValidatorChain()->attach($validator);
        $this->add($input);
        
        // Filtre pour le champ versionDate
//        $input = new \Zend\InputFilter\Input('versionDate');
//        $input->setRequired(true);
//        $filter = new \Zend\Filter\StringTrim();
//        $input->getFilterChain()->attach($filter);
//        $filter = new \Zend\Filter\StripTags();
//        $input->getFilterChain()->attach($filter);
//        $validator = new \Zend\Validator\Date('versionDate');
//        $validator->setFormat('Y-m-d');
//        $input->getFilterChain()->attach($validator);
//        $this->add($input);
        
    }
}
