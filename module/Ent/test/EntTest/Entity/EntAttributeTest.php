<?php

namespace EntTest\Entity;

use Ent\Entity\EntAttribute;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntAttributeTest
 *
 * @author mdjimbi
 */
class EntAttributeTest extends PHPUnit_Framework_TestCase
{

    protected $attribute;

    protected function setUp()
    {
        $this->attribute = new EntAttribute();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntAttribute.php';
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
        $this->assertNull($this->attribute->getAttributeId());
        $this->assertNull($this->attribute->getAttributeName());
        $this->assertNull($this->attribute->getAttributeLibelle());
        $this->assertNull($this->attribute->getAttributeDescription());
        $this->assertEmpty($this->attribute->getFkSaService());
    }
}
