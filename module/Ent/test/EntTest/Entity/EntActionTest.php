<?php

namespace EntTest\Entity;

use Ent\Entity\EntAction;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntActionTest
 *
 * @author mdjimbi
 */
class EntActionTest extends PHPUnit_Framework_TestCase
{

    protected $action;

    protected function setUp()
    {
        $this->action = new EntAction();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntAction.php';
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
        $this->assertNull($this->action->getActionId());
        $this->assertNull($this->action->getActionName());
        $this->assertNull($this->action->getActionLibelle());
        $this->assertNull($this->action->getActionDescription());
    }
}
