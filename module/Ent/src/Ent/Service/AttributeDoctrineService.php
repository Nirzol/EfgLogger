<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntAttribute;
use Ent\InputFilter\AttributeInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class AttributeDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntAttribute
     */
    protected $attribute;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var AttributeInputFilter
     */
    protected $attributeInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntAttribute $attribute, DoctrineObject $hydrator, AttributeInputFilter $attributeInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->attribute = $attribute;
        $this->hydrator = $hydrator;
        $this->attributeInputFilter = $attributeInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntAttribute');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntAttribute');

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
        $repo = $this->em->getRepository('Ent\Entity\EntAttribute');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntAttribute');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $attribute = $this->attribute;

        $form->setHydrator($this->hydrator);
        $form->bind($attribute);
        $filter = $this->attributeInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($attribute);
        $this->em->flush();

        return $attribute;
    }

    public function save(Form $form, $dataAssoc, $attribute = null)
    {
        /* @var $attribute EntAttribute */
        if (!$attribute === null) {
            $attribute = $this->attribute;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($attribute);
        $filter = $this->attributeInputFilter;
        $form->setInputFilter($filter->appendEditValidator($attribute->getAttributeId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($attribute);
        $this->em->flush();

        return $attribute;
    }

    public function delete($id)
    {
        $attribute = $this->getById($id);

        $this->em->remove($attribute);
        $this->em->flush();
    }

}
