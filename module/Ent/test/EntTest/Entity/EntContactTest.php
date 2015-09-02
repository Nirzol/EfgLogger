<?php

namespace EntTest\Entity;

use Ent\Entity\EntContact;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntContactTest
 *
 * @author fandria
 */
class EntContactTest extends PHPUnit_Framework_TestCase{
    protected $contact;
    
    protected function setUp() {
        $this->contact = new EntContact();
    }
    
    public static function setUpBeforeClass() {
        require_once __DIR__. '/../../../src/Ent/Entity/EntContact.php';
    }
    
    protected function tearDown() {
        parent::tearDown();
    }
    
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }
    
    public function testInitValuesAreNull() {
        $this->assertNull($this->contact->getContactId());
        $this->assertNull($this->contact->getContactName());
        $this->assertNull($this->contact->getContactLibelle());
        $this->assertNull($this->contact->getContactDescription());
        $this->assertNull($this->contact->getContactMailto());
        $this->assertNull($this->contact->getContactLastUpdate());
    }
}
