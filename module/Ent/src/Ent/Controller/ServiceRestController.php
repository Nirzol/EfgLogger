<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntService;
use Ent\Form\ServiceForm;
use Ent\Service\ServiceDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of ServiceRestController
 *
 * @author fandria
 */
class ServiceRestController extends AbstractRestfulController{
    /**
     *
     * @return ServiceDoctrineService
     */
    protected $serviceService;

    /**
     *
     * @var ServiceForm
     */
    protected $serviceForm;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;
    
    public function options()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();

        $headers->addHeaderLine('Allow', implode(',', array(
            'GET',
            'POST',
            'PUT',
            'DELETE',
        )))
        ->addHeaderLine('Content-Type','application/json; charset=utf-8');
        return $response;
    }
    

    public function __construct(ServiceDoctrineService $serviceService, ServiceForm $serviceForm, DoctrineObject $hydrator)
    {
        $this->serviceService = $serviceService;
        $this->serviceForm = $serviceForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->serviceService->getAll();

        $data = array();
        foreach ($results as $result) {
            /* @var $result EntService */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data)
        );
    }

    public function get($id)
    {
        /* @var $result EntService */
        $result = $this->serviceService->getById($id);

        $data[] = $result->toArray($this->hydrator);

        return new JsonModel(
                $result->toArray($this->hydrator)
        );
//        return new JsonModel(array(
//            'data' => $data)
//        );
    }

    public function create($data)
    {
        $form = $this->serviceForm;

        if ($data) {
                    
            $service = $this->serviceService->insert($form, $data);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été inséré.');

                return new JsonModel(array(
                    'data' => $service->getServiceId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le service a bien été inséré.',
                    ),
                ));
            }
        }
        return new JsonModel(array(
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le service n\'a pas été inséré.',
            ),
        ));
    }

    public function update($id, $data)
    {
        $service = $this->serviceService->getById($id, $this->serviceForm);

        if ($data) {
            $service = $this->serviceService->save($this->serviceForm, $data, $service);

            if ($service) {
                $this->flashMessenger()->addSuccessMessage('Le service a bien été updaté.');

                return new JsonModel(array(
                    'data' => $service->getServiceId(),
                    'success' => true,
                    'flashMessages' => array(
                        'success' => 'Le service a bien été updaté.',
                    ),
                ));
            }
        }

        return new JsonModel(array(
            'data' => $service,
            'success' => false,
            'flashMessages' => array(
                'error' => 'Le service n\'a pas été updaté.',
            ),
        ));
    }

    public function delete($id)
    {
        $this->serviceService->delete($id);

        $this->flashMessenger()->addSuccessMessage('Le service a bien été supprimé.');

        return new JsonModel(array(
            'data' => 'deleted',
            'success' => true,
            'flashMessages' => array(
                'error' => 'Le service a bien été supprimé.',
            ),
        ));
    }
}
