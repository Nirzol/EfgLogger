<?php


namespace Ent\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Ent\Entity\EntProfile;
use Ent\Form\ProfileForm;
use Ent\Service\ProfileDoctrineService;
use Zend\View\Model\JsonModel;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ProfileRestController extends AbstractRestfulController
{
    /**
     *
     * @var ProfileDoctrineService
     */
    protected $service;
    
    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;
    
    public function options()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();

        if ($this->params()->fromRoute('id', false)) {
            // Allow viewing, partial updating, replacement, and deletion
            // on individual items
            $headers->addHeaderLine('Allow', implode(',', array(
                'GET',
                'PATCH',
                'PUT',
                'DELETE',
            )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
            return $response;
        }

        // Allow only retrieval and creation on collections
        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
        )))->addHeaderLine('Content-Type','application/json; charset=utf-8');

        return $response;
    }


    public function __construct(ProfileDoctrineService $aService, DoctrineObject $hydrator) {
        $this->service = $aService;
        $this->hydrator = $hydrator;
    }
    
    public function getList() {
        $results = $this->service->getAll();
        
        $data = array();
        
        foreach ($results as $result) {
            /* @var $result EntProfile */
            $data[] = $result->toArray($this->hydrator);
        }
        
        return new JsonModel(array(
            'data' => $data
        ));
        
    }
    
    public function get($id) {
        
        $result = $this->service->getById($id);
        
        $data = array();
        
        if($result) {
            /* @var $result EntProfile */
            $data[] = $result->toArray($this->hydrator);
        }
        return new JsonModel(array(
            'data' => $data
        ));
    }
    
    public function create($data) {
        $form = new ProfileForm();
        
        if ($data) {
            $profile = $this->service->insert($form, $data);
            
            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été ajouté.');
                
                return new JsonModel(array(
                    'data' => $profile->getProfileId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le profile a bien été ajouté.'
                    ),
                ));
                
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le profile n\'a pas été ajouté.'
            ),
        ));
    }
    
    public function update($id, $data) {
        $form = new ProfileForm();
        
        $profile = $this->service->getById($id, $form);
        
        if ($data) {
            $profile = $this->service->update($id, $form, $data);
            
            if ($profile) {
                $this->flashMessenger()->addSuccessMessage('Le profile a bien été modifié.');
                
                return new JsonModel(array(
                    'data' => $profile->getProfileId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le profile a bien été modifié.'
                    ),
                ));
                
            }
        }
        
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le profile n\'a pas été modifié.'
            ),
        ));
    }
    
    public function delete($id) {
        $this->service->delete($id);
        
        $this->flashMessenger()->addSuccessMessage('Le profile a bien été supprimé.');
        
        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'success' => 'Le profile a bien été supprimé.',
            ),
        ));
    }
    
}

