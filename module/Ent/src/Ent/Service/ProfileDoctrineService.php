<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntProfile;
use Ent\InputFilter\ProfileInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

/**
 * Description of ProfileDoctrineService
 *
 * @author sebbar
 */
class ProfileDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntProfile
     */
    protected $profile;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var ProfileInputFilter
     */
    protected $profileInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntProfile $profile, DoctrineObject $hydrator, ProfileInputFilter $profileInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->profile = $profile;
        $this->hydrator = $hydrator;
        $this->profileInputFilter = $profileInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        $repository = $this->em->getRepository('Ent\Entity\EntProfile');

        return $repository->findAll();
    }

    public function getById($id, $form = null)
    {
        $repository = $this->em->getRepository('Ent\Entity\EntProfile');

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
        $repo = $this->em->getRepository('Ent\Entity\EntProfile');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntProfile');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntProfile');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $profile = $this->profile;

        $form->setHydrator($this->hydrator);
        $form->bind($profile);
        $filter = $this->profileInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($profile);
        $this->em->flush();

        return $profile;
    }

    public function save(Form $form, $dataAssoc, $profile = null)
    {
        /* @var $profile EntProfile */
        if (!$profile === null) {
            $profile = $this->profile;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($profile);
        $filter = $this->profileInputFilter;
        $form->setInputFilter($filter->appendEditValidator($profile->getProfileId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($profile);
        $this->em->flush();

        return $profile;
    }

    public function delete($id)
    {
        $profile = $this->getById($id);

        $this->em->remove($profile);
        $this->em->flush();

        return $profile;
    }

}
