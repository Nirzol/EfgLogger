<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class UserControllerTest extends AbstractControllerTestCase
{

    protected $traceError = true;
    protected $serviceManager;

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    protected function mockAuthorizationService()
    {
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);

        $authService = $this->getMockBuilder(\ZfcRbac\Service\AuthorizationService::class)->disableOriginalConstructor()->getMock();
        $authService->expects($this->any())
            ->method('isGranted')
            ->will($this->returnValue(true));

        $this->serviceManager->setService(\ZfcRbac\Service\AuthorizationService::class, $authService);
    }

    // PHP List
    public function testListActionIsAccessible()
    {
        $this->mockAuthorizationService();

        $this->dispatch('/api/user');

//        var_dump($this->getResponse()->getContent());
//        var_dump($this->getApplicationServiceLocator()->get('config'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\user');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('zfcadmin/user');
    }

    // REST getList
    public function testGetListIsAccessible()
    {
        $this->dispatch('/api/user-rest');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\userRest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('user-rest');
    }

    // PHP show
    // Problème : on dépend de la base de données qui risque d'évoluer
    // Il faudrait remplir la base dans le setUp
    public function testShowActionContainsUserWithMysql()
    {
        $this->mockAuthorizationService();

        $this->dispatch('/api/user/16');

        // On vérifie via un selecteur CSS (attention tous n'existent pas)
        // qu'il y a bien 3 paragraphe dans la réponse
        $this->assertResponseStatusCode(200);
//        $this->assertQueryCount('p', 3);
        $this->assertContains('egrondin', $this->getResponse()->getContent());
    }

    // Mock : pas besoin d'écrire la classe et permet de savoir
    // combien de fois sont appelées les méthodes
//    public function testShowActionContainsContactWithMock()
//    {
////        $mockService = $this->getMockBuilder(\AddressBook\Service\Contact\ContactServiceInterface::class)
////                            ->getMock();
//
//        $mockService = $this->getMockBuilder(\Ent\Service\UserDoctrineService::class)
//                            ->disableOriginalConstructor()
//                            ->getMock();
//
//        $mockService->expects($this->once())
//                    ->method('getById')
//                    ->willReturn((new \Ent\Entity\EntUser)
//                                             ->setUserId('100')
//                                             ->setUserLogin('bobama'));
//
//        $this->getApplicationServiceLocator()
//             ->setAllowOverride(true)
//             ->setService('Ent\Service', $mockService);
//
//        $this->dispatch('/user/100');
//
//        // On vérifie via un selecteur CSS (attention tous n'existent pas)
//        // qu'il y a bien 3 paragraphe dans la réponse
////        $this->assertQueryCount('p', 2);
//        $this->assertContains('bobama', $this->getResponse()->getContent());
//    }
    // REST get
    public function testGetIsAccessible()
    {
        $this->dispatch('/api/user-rest/2', 'GET');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\userRest');
        $this->assertActionName('get');
    }

    // REST create
//    public function testCreateIsAccessible() {
//        
//        $this->dispatch('/user-rest', 'POST', array('userLogin' => 'testUserRest2', 'userStatus' => '1', 'fkUrRole' => '1'), true);
//        
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\userrest');
//        $this->assertActionName('create');
//    }
//    
    // REST update
//    public function testUpdateIsAccessible()
//    {
//
//        $this->dispatch('/api/user-rest/36', 'PUT', array('userLogin' => 'testUserRestUpdate', 'userStatus' => '1', 'fkUrRole' => '1'));
//
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\userrest');
//        $this->assertActionName('update');
//        $this->assertContains('true', $this->getResponse()->getContent());
//    }
//    
//    // REST delete
//    public function testDeleteIsAccessible() {
//        
//        $this->dispatch('/user-rest/27', 'DELETE');
//        
//        $this->assertResponseStatusCode(200);
//        $this->assertModuleName('ent');
//        $this->assertControllerName('ent\controller\userrest');
//        $this->assertActionName('delete');
//    }
}
