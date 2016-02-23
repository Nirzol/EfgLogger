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
                
                $userTypeStaff = $this->request->getPost('userTypeStaff');
                
                $userTypeStudent = $this->request->getPost('userTypeStudent');
                
                if (!empty($search)) {
                    
                    if((strpos($search, "(") !== false) && (strpos($search, "(") == 0 )) {
                        try {
                            $result = $this->searchLdapModel->searchFilter($search);
                        } catch (LdapException $zle) {
                            //$message = $zle->getMessage();
                        }                        
                    } else {
                        if($userTypeStaff == '1' && $userTypeStudent == '0') {
                            $result = $this->searchLdapModel->searchUserStaff($search);
                        } elseif($userTypeStaff == '0' && $userTypeStudent == '1') {
                            $result = $this->searchLdapModel->searchUserStudent($search);
                        } else {
                            $result = $this->searchLdapModel->searchUser($search);
                        }                       
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
