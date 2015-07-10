<?php

namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Ent\Entity\EntModule;
use Ent\Entity\Ent;
use Ent\Form\ModuleForm;
use Ent\Service\ModuleDoctrineService;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;


class ModuleRestController extends AbstractRestfulController
{
    /**
     *
     * @var ModuleDoctrineService
     */
    protected $moduleService;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;


    public function __construct(ModuleDoctrineService $moduleService, DoctrineObject $hydrator) {
        $this->moduleService = $moduleService;
        $this->hydrator = $hydrator;
    }
    
    public function getList() {
        $results = $this->moduleService->getAll();
        
        $data = array();
        
        foreach ($results as $result) {
            /* @var $result EntModule */
            $data[] = $result->toArray($this->hydrator);
        }
        
        return new JsonModel(array(
            'data' => $data
        ));
        
    }
    
    public function get($id) {
        
        $result = $this->moduleService->getById($id);
        
        $data = array();
        
        if($result) {
            /* @var $result Ent */
            $data[] = $result->toArray($this->hydrator);
        }
        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function create($data) {
        $form = new ModuleForm();
        
        if ($data) {
            $module = $this->moduleService->insert($form, $data);
            
            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été ajouté.');
                
                return new JsonModel(array(
                    'data' => $module->getModuleId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le module a bien été ajouté.'
                    ),
                ));
                
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le module n\'a pas été ajouté.'
            ),
        ));
    }
    
    public function update($id, $data) {
        $form = new ModuleForm();
        
        $module = $this->moduleService->getById($id, $form);
        
        if ($data) {
            $module = $this->moduleService->update($id, $form, $data);
            
            if ($module) {
                $this->flashMessenger()->addSuccessMessage('Le module a bien été modifié.');
                
                return new JsonModel(array(
                    'data' => $module->getModuleId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le module a bien été modifié.'
                    ),
                ));
                
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le module n\'a pas été modifié.'
            ),
        ));
    }
    
    public function delete($id) {
        $this->moduleService->delete($id);
        
        $this->flashMessenger()->addSuccessMessage('Le module a bien été supprimé.');
        
        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'Le module a bien été supprimé.',
            ),
        ));
    }
}
