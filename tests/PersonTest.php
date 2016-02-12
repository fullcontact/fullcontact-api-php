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

    public function testLookupByEmail()
    {
        $person = $this->person->lookupByEmail('bart@fullcontact.com');

        $this->assertEquals('Bart', $person->contactInfo->givenName);
        $this->assertGreaterThan(5, count($person->contactInfo->websites));
        $this->assertGreaterThan(5, count($person->socialProfiles));
    }

    public function testLookupByPhone()
    {
        $person = $this->person->lookupByPhone('3037170414');

        $this->assertEquals('Bart', $person->contactInfo->givenName);
        $this->assertGreaterThan(5, count($person->contactInfo->websites));
        $this->assertGreaterThan(5, count($person->socialProfiles));
    }

    public function testLookupByTwitter()
    {
        $person = $this->person->lookupByTwitter('github');

        $this->assertEquals('GitHub',   $person->contactInfo->fullName);
        $this->assertEquals(5,          count($person->socialProfiles));
    }
}
