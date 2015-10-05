<?php

namespace Ent\Controller;

use Ent\Form\UserForm;
use Ent\Service\UserDoctrineService;
use SearchLdap\Controller\SearchLdapController;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @var UserDoctrineService
     */
    protected $userService = null;

    /**
     * @var UserForm
     */
    protected $userForm = null;
    protected $config = null;
    
    /**
     * @var SearchLdapController
     */
    protected $searchLdapController = null;

    public function __construct(UserDoctrineService $userService, UserForm $userForm, $config, SearchLdapController $searchLdapController)
    {
        $this->userService = $userService;
        $this->userForm = $userForm;
        $this->config = $config;
        $this->searchLdapController = $searchLdapController;
    }

    public function listAction()
    {
//        $user = $this->userService->findBy(array('userLogin' => 'ss'));
//        var_dump(!$user);
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        if ($authService->hasIdentity()) {
            var_dump($authService->getIdentity()->getUserLogin());
        } else {
            echo "nonono";
        }
        $users = $this->userService->getAll();

        return new ViewModel(array(
            'users' => $users,
        ));
    }

    public function addAction()
    {
        //TODO: une idée de début en commentaire...
        //        $container = new \Zend\Session\Container('noAuth');
        //        echo 'Avant le clear : ' . $container->login . $container->loginMessage;
        //        if ($container->login) {
        //            $data = $data = array('userLogin' => 'bibi', 'userStatus' => '1',
        //                'fkUrRole' => array('1'));
        //            $container->getManager()->getStorage()->clear('noAuth');
        //            
        //            //TODO : direct insert puis redirect vers /login
        //            
        //        }
        //        echo '<br />Après le clear : ' . $container->login;

        $form = $this->userForm;

        if ($this->request->isPost()) {
            //            if (!isset($data)) {
            $data = $this->request->getPost();
            //            }
            $user = $this->userService->insert($form, $data);
            //            $user = $this->userService->save($form, $this->request->getPost(), null);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');

                return $this->redirect()->toRoute('user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function addAutoAction()
    {
        $container = new Container('noAuth');

        $config = $this->config;

        if ($container->login) {
            // check primary affiliation
            $affiliation = $this->searchLdapController->getPrimaryAffiliationByUid($container->login);
            //if student
            if (strcmp($affiliation, 'student') === 0 ) {
                return $this->redirect()->toUrl('http://ent-ng.parisdescartes.fr');
            }
            
            $data = $data = array('userLogin' => $container->login, 'userStatus' => $config['status-base-id'],
                'fkUrRole' => array($config['role-base-id']), 'fkUpProfile' => array($config['profile-base-id']));

            $user = $this->userService->findBy(array('userLogin' => $container->login));

            if (!$user) {
                $form = $this->userForm;

                $user = $this->userService->insert($form, $data);
                if (!$user) {
                    //TODO handle exception
//                    return $this->notFoundAction();  A tester ???? ou autre....
                }
            }

            $container->getManager()->getStorage()->clear('noAuth');

            return $this->redirect()->toRoute('login');
        }
    }

    public function showAction()
    {
        $id = $this->params('id');

        $user = $this->userService->getById($id);

        if (!$user) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'user' => $user,
        ));
    }

    public function modifyAction()
    {
        $id = $this->params('id');
        $form = $this->userForm;
        $user = $this->userService->getById($id, $form);

        if ($this->request->isPost()) {
            $user = $this->userService->save($form, $this->request->getPost(), $user);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updaté.');

                return $this->redirect()->toRoute('user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        //        if (!$this->isGranted('delete')) {
        //            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        //        }
        $id = $this->params('id');

        $this->userService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');

        return $this->redirect()->toRoute('user');
    }

}
