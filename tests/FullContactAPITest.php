<?php

/**
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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

        $this->client_old = new FullContactAPI($apikey);
        $this->client_new = new Services_FullContact_API($apikey);

        parent::setUp();
    }

    public function testDoLookupEmail()
    {
        $result = $this->client_old->doLookup('bart@fullcontact.com');
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Lorang', $result['contactInfo']['familyName']);
        $this->assertGreaterThanOrEqual(11, count($result['socialProfiles']));
    }

    public function testBadEmail()
    {
        $result = $this->client_old->doLookup('bart@fullcontact');
        $this->assertEquals(422, $result['status']);
        $this->assertRegExp('/invalid/i', $result['message']);
    }

    public function testDoLookupPhone()
    {
        $result = $this->client_old->doLookup('3037170414', 'phone');
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Lorang', $result['contactInfo']['familyName']);
        $this->assertGreaterThanOrEqual(11, count($result['socialProfiles']));
    }

    public function testBadPhone()
    {
        $result = $this->client_old->doLookup('303717');
        $this->assertEquals(422, $result['status']);
        $this->assertRegExp('/invalid/i', $result['message']);
    }


    public function testDoLookupTwitter()
    {
        $result = $this->client_old->doLookup('lorangb', 'twitter');
        $this->assertArrayHasKey('status', $result);
        $this->assertEquals(200, $result['status']);
        $this->assertEquals('Lorang', $result['contactInfo']['familyName']);
        $this->assertGreaterThanOrEqual(11, count($result['socialProfiles']));
    }
}
