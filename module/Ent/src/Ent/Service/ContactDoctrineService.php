<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntContact;
use Ent\InputFilter\ContactInputFilter;
use Zend\Form\Form;

/**
 * Description of ContactDoctrineService
 *
 * @author fandria
 */
class ContactDoctrineService implements ContactServiceInterface{
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

    public function __construct(EntityManager $em, EntContact $contact, DoctrineObject $hydrator, ContactInputFilter $contactInputFilter)
    {
        $this->em = $em;
        $this->contact = $contact;
        $this->hydrator = $hydrator;
        $this->contactInputFilter = $contactInputFilter;
    }

    public function getAll()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        return $repo->findAll();
    }

    public function getAllRest()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact')->createQueryBuilder('Contact');

        return $repo->getQuery()->getArrayResult();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntContact');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
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

    public function save(Form $form, $dataAssoc, EntContact $contact = null)
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
        $this->em->remove($this->getById($id));
        $this->em->flush();
    }
}
