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

class NameTest extends PHPUnit_Framework_TestCase
{
    protected $name = null;

    public function setUp()
    {
        global $apikey;

        $this->name = new Services_FullContact_Name($apikey);

        parent::setUp();
    }

    public function testFailAPIKey()
    {
        $brokenRequest = new Services_FullContact_Name('nope, no good');

        $name = $brokenRequest->normalize('John');
        $this->assertEquals('403', $name->status);
        $this->assertRegExp('/invalid/i', $name->message);
    }

    public function testNormalize()
    {
        $name = $this->name->normalizer('John');
        $this->assertEquals('John', $name->nameDetails->givenName);
        $this->assertEquals('John', $name->nameDetails->fullName);

        $name = $this->name->normalizer('John Smith');
        $this->assertEquals('John', $name->nameDetails->givenName);
        $this->assertEquals('Smith', $name->nameDetails->familyName);

        $name = $this->name->normalizer('John Michael Smith');
        $this->assertEquals('John', $name->nameDetails->givenName);
        $this->assertEquals(1, count($name->nameDetails->middleNames));
        $this->assertEquals('Smith', $name->nameDetails->familyName);

        $name = $this->name->normalizer('Mr. John Michael Smith');
        $this->assertEquals('John', $name->nameDetails->givenName);
        $this->assertEquals(1, count($name->nameDetails->prefixes));
        $this->assertEquals('John Michael Smith', $name->nameDetails->fullName);

        $name = $this->name->normalizer('Mr. John Michael Smith Jr.');
        $this->assertEquals(1, count($name->nameDetails->prefixes));
        $this->assertEquals(1, count($name->nameDetails->suffixes));
        $this->assertEquals(0, count($name->nameDetails->nicknames));

        $name = $this->name->normalizer('Mr. John (Johnny) Michael Smith Jr.');
        $this->assertEquals(1, count($name->nameDetails->nicknames));
        $this->assertEquals('John Michael Smith', $name->nameDetails->fullName);
    }

    public function testDeducer()
    {
        $name = $this->name->deducer('caseysoftware', 'username');
        $this->assertEquals('Casey', $name->nameDetails->givenName);
        $this->assertEquals('Casey', $name->nameDetails->fullName);

        $name = $this->name->deducer('mike@example.com');
        $this->assertEquals('Mike', $name->nameDetails->givenName);
        $this->assertEquals('Mike', $name->nameDetails->fullName);

        $name = $this->name->deducer('fake@example.com');
        $this->assertEquals('Fake', $name->nameDetails->familyName);
        $this->assertEquals('Fake', $name->nameDetails->fullName);

        $name = $this->name->deducer('fake@example.com', 'email', 'uppercase');
        $this->assertEquals('FAKE', $name->nameDetails->fullName);
        $this->assertEquals('FAKE', $name->nameDetails->familyName);
    }

    public function testSimilarity()
    {
        $result = $this->name->similarity('John', 'Johnathan');
        $this->assertEquals('200', $result->status);
        $this->assertGreaterThan(0.8, $result->result->SimMetrics->jaroWinkler->similarity);

        $result = $this->name->similarity('John', 'Mike');
        $this->assertEquals(0, $result->result->FullContact->BigramAnalysis->dice->similarity);

        $result = $this->name->similarity('Michelle', 'Michael');
        $this->assertEquals('200', $result->status);
        $this->assertGreaterThan(0.9, $result->result->SimMetrics->jaroWinkler->similarity);
        $this->assertEquals(0.625, $result->result->SimMetrics->levenshtein->similarity);
    }
}