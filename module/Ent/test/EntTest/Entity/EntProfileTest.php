<?php

namespace EntTest\Entity;

use Ent\Entity\EntProfile;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntProfileTest
 *
 * @author mdjimbi
 */
class EntProfileTest extends PHPUnit_Framework_TestCase
{
    protected $profile;
    
    protected function setUp() {
        $this->profile = new EntProfile();
    }
    
    public static function setUpBeforeClass() {
        require_once __DIR__. '/../../../src/Ent/Entity/EntProfile.php';
    }
    
    protected function tearDown() {
        parent::tearDown();
    }
    
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }
    
    public function testInitValuesAreNull() {
        $this->assertNull($this->profile->getProfileId());
        $this->assertNull($this->profile->getProfileLdap());
        $this->assertNull($this->profile->getProfileName());
        $this->assertNull($this->profile->getProfileLibelle());
        $this->assertNull($this->profile->getProfileDescription());
        $this->assertEmpty($this->profile->getFkUpUser());
    }
}
