<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntLog;
use Ent\InputFilter\LogInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class LogDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntLog
     */
    protected $log;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var LogInputFilter
     */
    protected $logInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntLog $log, DoctrineObject $hydrator, LogInputFilter $logInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->log = $log;
        $this->hydrator = $hydrator;
        $this->logInputFilter = $logInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntLog');

//        return $repository->findAll();
        return $repository->findBy(array(), array("logOnline" => "DESC"), 100);
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntLog');

        $repoFind = $repository->find($id);

        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntLog');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntLog');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntLog');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $log = $this->log;

        $form->setHydrator($this->hydrator);
        $form->bind($log);
        $filter = $this->logInputFilter;
        $form->setInputFilter($filter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($log);
        $this->em->flush();

        return $log;
    }

    public function save(Form $form, $dataAssoc, $log = null)
    {
        /* @var $log EntLog */
        if (!$log === null) {
            $log = $this->log;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($log);
        $filter = $this->logInputFilter;
        $form->setInputFilter($filter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($log);
        $this->em->flush();

        return $log;
    }

    public function delete($id)
    {
        $log = $this->getById($id);

        $this->em->remove($log);
        $this->em->flush();
    }

//    public function insertEnterpriseObject($eo)
//    {
//
//
//        if (isset($eo) && ($eo instanceof EntLog)) {
//            $this->em->persist($eo);
//            $this->em->flush();
//            return $eo;
//        }
//
//        return null;
//    }
//    /**
//     * Sauvegarde d'un eo
//     * 
//     */
//    public function updateEnterpriseObject($eo)
//    {
//
//        if (isset($eo) && ($eo instanceof EntLog)) {
//            $this->em->refresh($eo);
//            $this->em->flush();
//            return $eo;
//        }
//
//        return null;
//    }
//    public function insertArray($dataArray)
//    {
//
//        $anEntLog = NULL;
//
//        if (isset($dataArray) && (count($dataArray) > 0)) {
//
//            try {
//                $anEntLog = new EntLog();
//
//                $hydrator = new DoctrineObject($this->em);
//
//                $hydrator->hydrate($dataArray, $anEntLog);
//
//                $this->insertEnterpriseObject($anEntLog);
//            } catch (Exception $exc) {
//                // echo $exc->getTraceAsString();
//                $anEntLog = NULL;
//            }
//        }
//
//        return $anEntLog;
//    }
//    public function insert(Form $form, $dataAssoc)
//    {
//        $eo = new EntLog();
//
//        $hydrator = new DoctrineObject($this->em);
//        $form->setHydrator($hydrator);
//
//        $form->bind($eo);
////        $form->setInputFilter(new LogInputFilter());
//        $form->setData($dataAssoc);
//
//        if (!$form->isValid()) {
//            return null;
//        }
//
//        $this->em->persist($eo);
//        $this->em->flush();
//
//        return $eo;
//    }
//
//    public function updateArray($id, $dataArray)
//    {
//
//        $anEntLog = $this->em->find('Ent\Entity\EntLog', $id);
//
//        $hydrator = new DoctrineObject($this->em);
//        $hydrator->hydrate($dataArray, $anEntLog);
//        $this->insertEnterpriseObject($anEntLog);
//
//        $this->em->persist($anEntLog);
//        $this->em->flush();
//
//        return $anEntLog;
//    }
//
//    public function update($id, Form $form, $dataAssoc)
//    {
//        $eo = $this->em->find('Ent\Entity\EntLog', $id);
//
//        $hydrator = new DoctrineObject($this->em);
//
//        $form->setHydrator($hydrator);
//        $form->bind($eo);
////        $form->setInputFilter(new LogInputFilter());
//        $form->setData($dataAssoc);
//
//        if (!$form->isValid()) {
//            error_log("ProfileDoctrineService.update: form is not valide !");
//            return null;
//        }
//
//        $this->em->persist($eo);
//        $this->em->flush();
//
//        return $eo;
//    }
//
//    public function delete($id)
//    {
//
//        $eo = $this->em->find('Ent\Entity\EntLog', $id);
//
//        $this->em->remove($eo);
//        $this->em->flush();
//
//        return $eo;
//    }
//    
//    public function logEvent($event) {
//        
//        if ( isset($event) && (strcmp($event, "") != 0) ) {
//            
//            /**
//             * @var EntUser
//             */
//            $eoUser = $this->getUserByLogin("sebbar");
//            if ( $eoUser) {
//                // IP, Session, Action : a determiner
//                $anEntLog = new EntLog();
//                $anEntLog->setFkLogUser($eoUser)
//                        ->setLogDatetime(new \DateTime())
//                        ->setLogIp("192.88.99.00")
//                        ->setLogLogin($eoUser->getLogin())
//                        ->setLogSession("sesion_4578000987")
//                        ->setLogUseragent("Agent Firefox");
//
//                if(strcmp($event, "login") == 0) {
//                    $anEntLog->setFkLogAction("Action_Login");
//                } else if(strcmp($event, "logout") == 0) {
//                    $anEntLog->setFkLogAction("Action_Logout");
//                }
//                $this->insertEnterpriseObject($eoUser);
//            }
//
//        }
//    }
}
