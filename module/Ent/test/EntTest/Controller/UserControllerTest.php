<?php

namespace EntTest\Controller;

class UserControllerTest extends \Zend\Test\PHPUnit\Controller\AbstractControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    // PHP List
    public function testListActionIsAccessible()
    {
        $this->dispatch('/user');

//        var_dump($this->getResponse()->getContent());
//        var_dump($this->getApplicationServiceLocator()->get('config'));

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\user');
        $this->assertActionName('list');
        $this->assertMatchedRouteName('user');
    }
    
    // REST getList
    public function testGetListIsAccessible() {
        $this->dispatch('/user-rest');

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
        $this->dispatch('/user/16');

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
    public function testGetIsAccessible() {
        $this->dispatch('/user-rest/2', 'GET');

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
    public function testUpdateIsAccessible() {
        
        $this->dispatch('/user-rest/36', 'PUT', array('userLogin' => 'testUserRestUpdate', 'userStatus' => '1', 'fkUrRole' => '1'));
        
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\userrest');
        $this->assertActionName('update');
        $this->assertContains('true', $this->getResponse()->getContent());
    }
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
