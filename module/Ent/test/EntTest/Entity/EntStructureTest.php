<?php

namespace EntTest\Entity;

use Ent\Entity\EntStructure;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntStructureTest
 *
 * @author fandria
 */
class EntStructureTest extends PHPUnit_Framework_TestCase {
    protected $structure;
    
    protected function setUp() {
        $this->structure = new EntStructure();
    }
    
    public static function setUpBeforeClass() {
        require_once __DIR__. '/../../../src/Ent/Entity/EntStructure.php';
    }
    
    protected function tearDown() {
        parent::tearDown();
    }
    
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }
    
    public function testInitValuesAreNull() {
        $this->assertNull($this->structure->getStructureId());
        $this->assertNull($this->structure->getStructureFatherid());
        $this->assertNull($this->structure->getStructureType());
        $this->assertNull($this->structure->getStructureCode());
        $this->assertNull($this->structure->getStructureLibelle());
        $this->assertNull($this->structure->getStructureIsValid());
        $this->assertNull($this->structure->getServiceLastUpdate());
    }
}
