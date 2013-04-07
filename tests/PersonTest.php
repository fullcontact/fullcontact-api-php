<?php

include_once 'creds.php';
include_once 'Services/FullContact.php';

/**
 * This class doesn't do much yet..
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */

class PersonTest extends PHPUnit_Framework_TestCase
{
    protected $person = null;

    public function setUp()
    {
        global $apikey;

        $this->person = new Services_FullContact_Person($apikey);

        parent::setUp();
    }

    public function atestLookupByEmail()
    {
        $person = $this->person->lookupByEmail('bart@fullcontact.com');

        $this->assertEquals('Bart', $person->contactInfo->givenName);
        $this->assertGreaterThan(5, count($person->contactInfo->websites));
        $this->assertGreaterThan(5, count($person->socialProfiles));
    }

    public function testLookupByPhone()
    {
        $person = $this->person->lookupByPhone('7039638997');

        $this->assertEquals('Keith',    $person->contactInfo->givenName);
        $this->assertGreaterThan(5 ,    count($person->socialProfiles));
    }

    public function testLookupByTwitter()
    {
        $person = $this->person->lookupByTwitter('github');

        $this->assertEquals('GitHub',   $person->contactInfo->fullName);
        $this->assertEquals(5,          count($person->socialProfiles));
    }

    public function testLookupByFacebook()
    {
        $this->markTestIncomplete();
    }
}