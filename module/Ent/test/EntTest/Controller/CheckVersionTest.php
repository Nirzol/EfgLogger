<?php

namespace EntTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class CheckVersionTest extends AbstractControllerTestCase
{

    protected function setUp()
    {
        $this->setApplicationConfig(require 'config/application.config.php');
    }

    /*     * ******************************************
     *
     * Test du controlleur VersionRestController
     *
     */

    public function getVersionConfig()
    {
        $conf = include __DIR__ . '/../../../../../config/autoload/global.php';
        return $conf['versions'];
    }

    public function testModuleVersionIsMatchingDataBaseVersion()
    {

        // Utilisation du controlleur VersionRest
        $this->dispatch('/api/version-rest');

        // Version de la base de donnees
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('ent');
        $this->assertControllerName('ent\controller\versionrest');
        $this->assertActionName('getList');
        $this->assertMatchedRouteName('version-rest');
        $json = $this->getResponse()->getContent();
        $versions = json_decode($json, true);
        $lastVersionArray = end($versions['data']);
        $lastVersion = $lastVersionArray['version'];

        // Version du module Ent dans le fichier de config
        $conf = $this->getVersionConfig();
        $bdVersionRequired = $conf['dependencies']['data-base-version'];

        // Test du matching
        $this->assertEquals($bdVersionRequired, $lastVersion);
    }
}
