<?php

namespace EntTest\Entity;

use Ent\Entity\EntStatus;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntStatusTest
 *
 * @author mdjimbi
 */
class EntStatusTest extends PHPUnit_Framework_TestCase
{

    protected $status;

    protected function setUp()
    {
        $this->status = new EntStatus();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntStatus.php';
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
    }

    public function testInitValuesAreNull()
    {
        $this->assertNull($this->status->getStatusId());
        $this->assertNull($this->status->getStatusName());
        $this->assertNull($this->status->getStatusLibelle());
        $this->assertNull($this->status->getStatusDescription());
        $this->assertNull($this->status->getStatusLastUpdate());
    }
}
