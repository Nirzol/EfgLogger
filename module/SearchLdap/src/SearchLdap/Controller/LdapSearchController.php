<?php

namespace SearchLdap\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Ldap\Exception\LdapException;
use SearchLdap\Model\SearchLdap;
use Zend\Http\Request;
use SearchLdap\Form\LdapSearchForm;
use SearchLdap\InputFilter\LdapSearchFilter;

/**
 * Description of LdapSearchController
 *
 * @author mdjimbi
 */

class LdapSearchController extends AbstractActionController {

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     *
     * @var SearchLdap
     */
    protected $searchLdapModel;
    
    /**
     *
     * @var LdapSearchForm
     */
    protected $searchLdapForm;
    
    /**
     *
     * @var LdapSearchFiler
     */
    protected $searchLdapFilter;

    public function __construct(SearchLdap $searchLdapModel, LdapSearchForm $searchLdapForm, LdapSearchFilter $searchLdapFilter) {
        $this->searchLdapModel = $searchLdapModel;
        $this->searchLdapForm = $searchLdapForm;
        $this->searchLdapFilter = $searchLdapFilter;
    }

    public function searchAction() {
        $form = $this->searchLdapForm;

        $request = $this->request;
               
        if ($request->isPost()) {
            $filter = $this->searchLdapFilter;

            $form->setInputFilter($filter);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $search = $this->request->getPost('searchValue');
                
                if (!empty($search)) {
                    
                    if((strpos($search, "(") !== false) && (strpos($search, "(") == 0 )) {
                        try {
                            $result = $this->searchLdapModel->searchFilter($search);
                        } catch (LdapException $zle) {
                            //$message = $zle->getMessage();
                        }                        
                    } else {
                       $result = $this->searchLdapModel->searchUser($search);
                    }
                    
                    if (empty($result)) {
                        $message = 'Aucune personne trouvée';                        
                    }                  
                }
            }           
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
            'result' => $result,
            'message' => $message,
        ));
    }

}
