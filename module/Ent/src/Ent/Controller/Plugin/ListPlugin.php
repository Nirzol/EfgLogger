<?php

namespace Ent\Controller\Plugin;

use Ent\Service\ListDoctrineService;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Description of ListPlugin
 *
 * @author egrondin
 */
class ListPlugin extends AbstractPlugin
{
    
    /* @var $listService ListDoctrineService */
    protected $listService;
    
    // Connexion LDAP direct into Factory
    public function __construct($listService) {
        $this->listService = $listService;
    }

    public function getListLibelle($listId)
    {
        $item = $this->listService->getById($listId);
        
        return $item->getListLibelle();
    }

}
