<?php

namespace SearchLdapTest\Model;

use SearchLdap\Model\SearchLdap;
use PHPUnit_Framework_TestCase;

class SearchLdapTest extends PHPUnit_Framework_TestCase
{

    public function testSearchLdapSearchUser()
    {
        $ldap = new SearchLdap();

        $ldap->ldapConnect();

        $searchValue = "mdjimbi";

        $user = $ldap->searchUser($searchValue);
        //var_dump($user);

        $this->assertNotNull($user);
        $this->assertTrue(count($user) > 0);
//        $this->assertEquals(array("Djimbi Malik Darel"), $user[0]['cn']);
//        $this->assertEquals(array("malik-darel.djimbi@parisdescartes.fr"), $user[0]['mail']);
//        $this->assertEquals(array(0 => "staff", 1 => "member", 2 => "employee"), $user[0]['edupersonaffiliation']);
//        $this->assertEquals(array("mdjimbi"), $user[0]['uid']);
    }
}
