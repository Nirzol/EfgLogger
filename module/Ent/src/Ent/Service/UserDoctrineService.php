<?php

namespace Ent\Service;

use Ent\Entity\EntUser;
use Ent\InputFilter\UserInputFilter;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Form\Form;

class UserDoctrineService implements UserServiceInterface
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
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(EntityManager $em, EntUser $user, DoctrineObject $hydrator, UserInputFilter $userInputFilter, \ZfcRbac\Service\AuthorizationService $authorizationService)
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

    public function insert(Form $form, $dataAssoc)
    {
        $user = $this->user;

        $form->setHydrator($this->hydrator);

        $form->bind($user);
        $form->setInputFilter($this->userInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
            return null;
        }
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function save(Form $form, $dataAssoc, EntUser $user = null)
    {
        if (!$user === null) {
            $user = $this->user;
        }

        $form->setHydrator($this->hydrator);

        $form->bind($user);
        $form->setInputFilter($this->userInputFilter);
        $form->setData($dataAssoc);

        if (!$form->isValid()) {
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
