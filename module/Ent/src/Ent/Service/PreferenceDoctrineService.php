<?php

namespace Ent\Service;

use Zend\Form\Form;
use Ent\Entity\EntPreference;
use Ent\InputFilter\PreferenceInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use ZfcRbac\Service\AuthorizationService;

class PreferenceDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntPreference
     */
    protected $preference;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var PreferenceInputFilter
     */
    protected $preferenceInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntPreference $preference, DoctrineObject $hydrator, PreferenceInputFilter $preferenceInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->preference = $preference;
        $this->hydrator = $hydrator;
        $this->preferenceInputFilter = $preferenceInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntPreference');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntPreference');

        $repoFind = $repository->find($id);

        if ($form != null) {
            /* @var $form Form */
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }
    
    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPreference');

        $repoFindOneBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindOneBy;
    }
    
    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntPreference');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }
    
    public function matching(\Doctrine\Common\Collections\Criteria $criteria){
        $repo = $this->em->getRepository('Ent\Entity\EntPreference');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
        
    }

    public function insert(Form $form, $dataAssoc)
    {
        $preference = $this->preference;

        $form->setHydrator($this->hydrator);
        $form->bind($preference);
        $form->setInputFilter($this->preferenceInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($preference);
        $this->em->flush();

        return $preference;
    }

    public function save(Form $form, $dataAssoc, $preference = null)
    {
        /* @var $preference EntPreference */
        if (!$preference === null) {
            $preference = $this->preference;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($preference);
        $form->setInputFilter($this->preferenceInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($preference);
        $this->em->flush();

        return $preference;
    }

    public function delete($id)
    {
        $preference = $this->getById($id);

        $this->em->remove($preference);
        $this->em->flush();
    }

}
