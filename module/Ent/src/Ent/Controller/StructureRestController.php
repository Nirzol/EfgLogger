<?php

namespace Ent\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntStructure;
use Ent\Form\StructureForm;
use Ent\Service\StructureDoctrineService;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

/**
 * Description of StructureRestController
 *
 * @author fandria
 */
class StructureRestController extends AbstractRestfulController
{

    /**
     *
     * @return StructureDoctrineService
     */
    protected $structureService;

    /**
     *
     * @var StructureForm
     */
    protected $structureForm;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

//    public function options()
//    {
//        $response = $this->getResponse();
//        $headers  = $response->getHeaders();
//
//        if ($this->params()->fromRoute('id', false)) {
//            // Allow viewing, partial updating, replacement, and deletion
//            // on individual items
//            $headers->addHeaderLine('Allow', implode(',', array(
//                'GET',
//                'PATCH',
//                'PUT',
//                'DELETE',
//            )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
//            return $response;
//        }
//
//        // Allow only retrieval and creation on collections
//        $headers->addHeaderLine('Allow', implode(',', array(
//            'GET',
//            'POST',
//        )))->addHeaderLine('Content-Type','application/json; charset=utf-8');
//
//        return $response;
//    }


    public function __construct(StructureDoctrineService $structureService, StructureForm $structureForm, DoctrineObject $hydrator)
    {
        $this->structureService = $structureService;
        $this->structureForm = $structureForm;
        $this->hydrator = $hydrator;
    }

    public function getList()
    {
        $results = $this->structureService->getAll();

        $data = array();
        foreach ($results as $result) {
            /* @var $result EntStructure */
            $data[] = $result->toArray($this->hydrator);
        }

        return new JsonModel(array(
            'data' => $data));
    }

    public function get($id)
    {
        /* @var $result EntStructure */
        $result = $this->structureService->getById($id);

        $data[] = $result->toArray($this->hydrator);

        return new JsonModel(
            $result->toArray($this->hydrator)
        );
//        return new JsonModel(array(
//            'data' => $data)
//        );
    }

    // EN SOMMEIL
    public function create($data)
    {
//        $form = $this->structureForm;
//
//        if ($data) {
//                    
//            $structure = $this->structureService->insert($form, $data);
//
//            if ($structure) {
//                $this->flashMessenger()->addSuccessMessage('La structure a bien été insérée.');
//
//                return new JsonModel(array(
//                    'data' => $structure->getStructureId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'La structure  a bien été insérée.',
//                    ),
//                ));
//            }
//        }
//        return new JsonModel(array(
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'La structure n\'a pas été insérée.',
//            ),
//        ));
    }

    // EN SOMMEIL
    public function update($id, $data)
    {
//        $structure = $this->structureService->getById($id, $this->structureForm);
//
//        if ($data) {
//            $structure = $this->structureService->save($this->structureForm, $data, $structure);
//
//            if ($structure) {
//                $this->flashMessenger()->addSuccessMessage('La structure a bien été updatée.');
//
//                return new JsonModel(array(
//                    'data' => $structure->getStructureId(),
//                    'success' => true,
//                    'flashMessages' => array(
//                        'success' => 'La structure a bien été updatée.',
//                    ),
//                ));
//            }
//        }
//
//        return new JsonModel(array(
//            'data' => $structure,
//            'success' => false,
//            'flashMessages' => array(
//                'error' => 'La structure n\'a pas été updatée.',
//            ),
//        ));
    }

    // EN SOMMEIL
    public function delete($id)
    {
//        $this->structureService->delete($id);
//
//        $this->flashMessenger()->addSuccessMessage('La structure a bien été supprimée.');
//
//        return new JsonModel(array(
//            'data' => 'deleted',
//            'success' => true,
//            'flashMessages' => array(
//                'error' => 'La structure a bien été supprimée.',
//            ),
//        ));
    }
}
