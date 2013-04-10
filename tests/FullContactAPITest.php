<?php

include_once 'creds.php';
include_once 'src/FullContact.php';
include_once 'Services/FullContact.php';

/**
 * This class doesn't do much yet..
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */

class FullContactAPITest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        global $apikey;

        $this->client = new FullContactAPI($apikey);

        parent::setUp();
    }

    public function testFailAPIKey()
    {
        $brokenRequest = new Services_FullContact_Name('nope, no good');

        $name = $brokenRequest->normalize('John');
        $this->assertEquals('403', $name->status);
        $this->assertRegExp('/invalid/i', $name->message);
    }

    public function testDoLookupEmail()
    {
        $result = $this->client->doLookup('bart@fullcontact.com');
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Lorang', $result['contactInfo']['familyName']);
        $this->assertGreaterThanOrEqual(11, count($result['socialProfiles']));
    }

    public function testDoLookupPhone()
    {
        $this->markTestIncomplete();
    }

    public function testDoLookupTwitter()
    {
        $this->markTestIncomplete();
    }

    public function testDoLookupFacebook()
    {
        $this->markTestIncomplete();
    }
}