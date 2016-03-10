<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ent\Service;

use Zend\Form\Form;
use Doctrine\ORM\EntityManager;
use Ent\Entity\EntVersion;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\InputFilter\VersionInputFilter;
use Ent\Service\DoctrineService;
use ZfcRbac\Service\AuthorizationService;

/**
 * Description of VersionDoctrineService
 *
 * @author sebbar
 */
class VersionDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, AuthorizationService $authorizationService)
    {
        $this->entityManager = $em;
        $this->authorizationService = $authorizationService;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->entityManager->getRepository('Ent\Entity\EntVersion');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function getAll()
    {
        $repository = $this->entityManager->getRepository('Ent\Entity\EntVersion');

//        return $repository->findAll();
        return $repository->findBy(array(), array('id' => 'ASC'));
    }

    public function getById($id, $form = null)
    {
        $repository = $this->entityManager->getRepository('Ent\Entity\EntVersion');

        $repoFind = $repository->find($id);

        if ($form != null) {
            $hydrator = new DoctrineObject($this->entityManager);
            $form->setHydrator($hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntVersion');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntVersion');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    /**
     * Returns the last inserted enterprise object
     *
     * @return type Ent\Entity\EntVersion
     */
    public function getLastInserted()
    {

        $repository = $this->entityManager->getRepository('Ent\Entity\EntVersion');
        $tempArray = $repository->findBy(array(), array('id' => 'ASC'));

        if (isset($tempArray) && is_array($tempArray) && (count($tempArray) > 0)) {
            return end($tempArray);
        }

        return null;
    }

    public function delete($id)
    {

        /* @var $version EntVersion */
        $version = $this->entityManager->find('Ent\Entity\EntVersion', $id);

        $this->entityManager->remove($version);
        $this->entityManager->flush();

        return $version;
    }

    public function save(Form $form, $dataAssoc, $version = null)
    {
        $this->insert($form, $dataAssoc);
    }

    public function insert(Form $form, $dataAssoc)
    {
        $version = new EntVersion();

        $hydrator = new DoctrineObject($this->entityManager);
        $form->setHydrator($hydrator);

        $form->bind($version);
        $form->setInputFilter(new \Ent\InputFilter\VersionInputFilter());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
//            error_log("====== Erreur: Probleme d'enrigistrement de la version dans la base :");
//            error_log("====== Erreur: Version = " . $version->toString());
            return null;
        }

        $this->entityManager->persist($version);
        $this->entityManager->flush();

        return $version;
    }

    public function update($id, Form $form, $dataAssoc)
    {
        $version = $this->entityManager->find('Ent\Entity\EntVersion', $id);

        $hydrator = new DoctrineObject($this->entityManager);

        $form->setHydrator($hydrator);
        $form->bind($version);
        $form->setInputFilter(new VersionInputFilter());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            error_log("==== Erreur: VersionDoctrineService.update: form is not valide !");
        } else {
            // Enregistrement dans la base
            $this->entityManager->persist($version);
            $this->entityManager->flush();
        }

        return $version;
    }

}
