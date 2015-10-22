<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntContact;
use Ent\InputFilter\ContactInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

/**
 * Description of ContactDoctrineService
 *
 * @author fandria
 */
class ContactDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntContact
     */
    protected $contact;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ContactInputFilter
     */
    protected $contactInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntContact $contact, DoctrineObject $hydrator, ContactInputFilter $contactInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->contact = $contact;
        $this->hydrator = $hydrator;
        $this->contactInputFilter = $contactInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        return $repo->findAll();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        $repoFind = $repo->find($id);

        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $contact = $this->contact;

        $form->setHydrator($this->hydrator);
        $form->bind($contact);
        $form->setInputFilter($this->contactInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        
        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }

    public function save(Form $form, $dataAssoc, $contact = null)
    {
        if (!$contact === null) {
            $contact = $this->contact;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($contact);
        $form->setInputFilter($this->contactInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }

        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }

    public function delete($id)
    {
        $contact = $this->getById($id);
        
        $this->em->remove($contact);
        $this->em->flush();
    }

}
