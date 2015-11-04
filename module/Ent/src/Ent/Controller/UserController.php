<?php

namespace Ent\Controller;

use Ent\Form\UserForm;
use Ent\Service\UserDoctrineService;
use SearchLdap\Controller\SearchLdapController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\XmlRpc\Request;

class UserController extends AbstractActionController
{

    /**
     * 
     * @var Request
     */
    protected $request = null;

    /**
     * 
     * @var UserDoctrineService
     */
    protected $userService = null;

    /**
     * 
     * @var UserForm
     */
    protected $userForm = null;
    protected $config = null;

    /**
     * 
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
        if (!$this->isGranted('list_user')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
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
        if (!$this->isGranted('add_user')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $form = $this->userForm;

        if ($this->request->isPost()) {
            //            if (!isset($data)) {
//            $data = $this->request->getPost();
            //            }
            $user = $this->userService->insert($form, $this->request->getPost());
            //            $user = $this->userService->save($form, $this->request->getPost(), null);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été insérer.');

                return $this->redirect()->toRoute('zfcadmin/user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    /**
     * Add and check user if not exist in database after login
     * 
     * @return void
     */
    public function addAutoAction()
    {
        $container = new Container('noAuth');

        $config = $this->config;

        if ($container->login) {
            // Check primary affiliation to redirect if user is a student
            $affiliation = $this->searchLdapController->getPrimaryAffiliationByUid($container->login);
            if ($affiliation === 'student') { // === optimisation est + rapide que strcmp
                return $this->redirect()->toUrl($config['student_redirect_url']);
            }

            $data = $data = array('userLogin' => $container->login, 'userStatus' => $config['status_default_id'],
                'fkUrRole' => array($config['role_default_id']), 'fkUpProfile' => array($config['profile_default_id']));

            // Test if user already in database, if not insert it !
            $user = $this->userService->findBy(array('userLogin' => $container->login));
            if (!$user) {
                $form = $this->userForm;

                $user = $this->userService->insert($form, $data);
                if (!$user) {
                    //TODO handle exception
                    return $this->notFoundAction();  //A tester ???? ou autre....
                }
            }

            // Don't need to keep this container because zf2 identity will be ok after redirect to login.
            $container->getManager()->getStorage()->clear('noAuth');

            return $this->redirect()->toRoute('login');
        } else {
            error_log("Le container dans UserController est vide");
//            return $this->notFoundAction();
            return $this->redirect()->toRoute('login');
        }
    }

    public function showAction()
    {
        if (!$this->isGranted('show_user')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');

        $user = $this->userService->getById($id);

        if (!$user) {
            return $this->notFoundAction();
        }

        return new ViewModel(array(
            'user' => $user,
        ));
    }

    public function updateAction()
    {
        if (!$this->isGranted('update_user')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }

        $id = $this->params('id');
        $form = $this->userForm;
        $user = $this->userService->getById($id, $form);

        if ($this->request->isPost()) {
            $user = $this->userService->save($form, $this->request->getPost(), $user);

            if ($user) {
                $this->flashMessenger()->addSuccessMessage('L\'user a bien été updaté.');

                return $this->redirect()->toRoute('zfcadmin/user');
            }
        }

        return new ViewModel(array(
            'form' => $form->prepare(),
        ));
    }

    public function deleteAction()
    {
        if (!$this->isGranted('delete_user')) {
            throw new \ZfcRbac\Exception\UnauthorizedException('You are not allowed !');
        }
        $id = $this->params('id');

        $this->userService->delete($id);

        $this->flashMessenger()->addSuccessMessage('L\'user a bien été supprimé.');

        return $this->redirect()->toRoute('zfcadmin/user');
    }

}
