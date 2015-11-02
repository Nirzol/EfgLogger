<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Ent\Entity\EntUser;
use Ent\InputFilter\UserInputFilter;
use Zend\Form\Form;
use ZfcRbac\Service\AuthorizationService;

class UserDoctrineService extends DoctrineService implements ServiceInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $em;

    /**
     *
     * @var EntUser
     */
    protected $user;

    /**
     *
     * @var DoctrineObject
     */
    protected $hydrator;

    /**
     *
     * @var UserInputFilter
     */
    protected $userInputFilter;

    /**
     *
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntUser $user, DoctrineObject $hydrator, UserInputFilter $userInputFilter, AuthorizationService $authorizationService)
    {
        $this->em = $em;
        $this->user = $user;
        $this->hydrator = $hydrator;
        $this->userInputFilter = $userInputFilter;
        $this->authorizationService = $authorizationService;
    }

    public function getAll()
    {
        // First check permission
//        if (!$this->authorizationService->isGranted('read')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $repo = $this->em->getRepository('Ent\Entity\EntUser');

        return $repo->findAll();
    }

    public function getAllRest()
    {
        $repo = $this->em->getRepository('Ent\Entity\EntUser')->createQueryBuilder('User');

        return $repo->getQuery()->getArrayResult();
    }

    public function getById($id, $form = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntUser');

        $repoFind = $repo->find($id);

        if ($form != null) {
            $form->setHydrator($this->hydrator);
            $form->bind($repoFind);
        }

        return $repoFind;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntUser');

        $repoFindBy = $repo->findBy($criteria, $orderBy, $limit, $offset);

        return $repoFindBy;
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntUser');

        $repoFindOneBy = $repo->findOneBy($criteria, $orderBy);

        return $repoFindOneBy;
    }

    public function matching(\Doctrine\Common\Collections\Criteria $criteria)
    {
        $repo = $this->em->getRepository('Ent\Entity\EntUser');

        $repoMatching = $repo->matching($criteria);

        return $repoMatching;
    }

    public function insert(Form $form, $dataAssoc)
    {
        $user = $this->user;

        $form->setHydrator($this->hydrator);
        $form->bind($user);
        $filter = $this->userInputFilter;
        $form->setInputFilter($filter->appendAddValidator());
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function save(Form $form, $dataAssoc, $user = null)
    {
        /* @var $user EntUser */
        if (!$user === null) {
            $user = $this->user;
        }

        $form->setHydrator($this->hydrator);
        $form->bind($user);
        $filter = $this->userInputFilter;
        $form->setInputFilter($filter->appendEditValidator($user->getUserId()));
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            $this->addFormMessageToErrorLog($form->getMessages());
            return null;
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function delete($id)
    {
        $user = $this->getById($id);

        // First check permission
//        if (!$this->authorizationService->isGranted('delete')) {
//            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
//        }
        $this->em->remove($user);
        $this->em->flush();
    }

}
