<?php

namespace SearchLdap\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SearchLdapPlugin extends AbstractPlugin
{
    /* @var $searchLdapModel \SearchLdap\Model\SearchLdap */

    protected $searchLdapModel;

    // Connexion LDAP direct into Factory
    public function __construct($searchLdapModel)
    {
        $this->searchLdapModel = $searchLdapModel;
    }

    public function searchUser($itemToSearch)
    {
        return $this->searchLdapModel->searchUser($itemToSearch);
    }

    public function getUserInfo($uid)
    {
        return $this->searchLdapModel->getUserInfo($uid);
    }

    public function getMailHostByUid($uid)
    {
        $searchResult = $this->getUserInfo($uid);

        if (!empty($searchResult)) {
            return ($searchResult['mailhost']) ? $searchResult['mailhost'][0] : null;
        }

        return null;
    }

    public function getMailByUid($uid)
    {
        $searchResult = $this->getUserInfo($uid);

        if (!empty($searchResult)) {
            return ($searchResult['mail']) ? $searchResult['mail'][0] : null;
        }

        return null;
    }

}
