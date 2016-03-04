<?php

namespace EntTest\Entity;

use Ent\Entity\EntPreference;
use PHPUnit_Framework_TestCase;

/**
 * Description of EntPreferenceTest
 *
 * @author mdjimbi
 */
class EntPreferenceTest extends PHPUnit_Framework_TestCase
{

    protected $preference;

    protected function setUp()
    {
        $this->preference = new EntPreference();
    }

    public static function setUpBeforeClass()
    {
        require_once __DIR__ . '/../../../src/Ent/Entity/EntPreference.php';
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
        $this->assertNull($this->preference->getPrefId());
        $this->assertNull($this->preference->getPrefAttribute());
        $this->assertEmpty($this->preference->getFkPrefProfile());
        $this->assertEmpty($this->preference->getFkPrefService());
        $this->assertEmpty($this->preference->getFkPrefStatus());
        $this->assertEmpty($this->preference->getFkPrefUser());
    }
}
