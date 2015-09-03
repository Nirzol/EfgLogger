<?php

namespace EntTest\Entity;

use Ent\Entity\EntLog;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntLogTest
 *
 */
class EntLogTest extends PHPUnit_Framework_TestCase
{
    protected $log;
    
    protected function setUp() {
        $this->log = new EntLog();
    }
    
    public static function setUpBeforeClass() {
        require_once __DIR__. '/../../../src/Ent/Entity/EntLog.php';
    }
    
    protected function tearDown() {
        parent::tearDown();
    }
    
    public static function tearDownAfterClass() {
        parent::tearDownAfterClass();
    }
    
    public function testInitValuesAreNull() {
        $this->assertNull($this->log->getLogId());
        $this->assertNull($this->log->getLogDatetime());
        $this->assertEmpty($this->log->getLogIp());
        $this->assertEmpty($this->log->getLogLogin());
        $this->assertEmpty($this->log->getLogOffline());
        $this->assertEmpty($this->log->getLogOnline());
        $this->assertEmpty($this->log->getLogSession());
        $this->assertEmpty($this->log->getLogUseragent());
        $this->assertNull($this->log->getFkLogAction());
        $this->assertNull($this->log->getFkLogModule());
        $this->assertNull($this->log->getFkLogUser());
    }
}
