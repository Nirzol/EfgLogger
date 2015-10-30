<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntStructure;
use Ent\InputFilter\StructureInputFilter;
use Zend\Form\Form;

/**
 * Description of StructureDoctrineService
 *
 * @author fandria
 */
class StructureDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntStructure
     */
    protected $structure;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var StructureInputFilter
     */
    protected $structureInputFilter;

    public function __construct(EntityManager $em, EntStructure $structure, DoctrineObject $hydrator, StructureInputFilter $structureInputFilter)
    {
        $this->em = $em;
        $this->structure = $structure;
        $this->hydrator = $hydrator;
        $this->structureInputFilter = $structureInputFilter;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStructure');

        return $repo->findAll();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStructure');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStructure');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStructure');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntStructure');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $structure = $this->structure;

        $form->setHydrator($this->hydrator);

        $form->bind($structure);
        $form->setInputFilter($this->structureInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }
        $this->em->persist($structure);
        $this->em->flush();

        return $structure;
    }

    public function save(Form $form, $dataAssoc, EntStructure $structure = null)
    {
        if (!$structure === null) {
            $structure = $this->structure;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($structure);
        $form->setInputFilter($this->structureInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($structure);
        $this->em->flush();

        return $structure;
    }

    public function delete($id)
    {
        $this->em->remove($this->getById($id));
        $this->em->flush();
    }

}
