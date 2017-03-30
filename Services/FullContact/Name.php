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

/**
 * This class handles everything related to names that aren't person-based info lookup
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Name extends Services_FullContact
{
    /**
     * Supported lookup methods
     * @var $_supportedMethods
     */
    protected $_supportedMethods = array('normalizer', 'deducer', 'similarity', 'stats', 'parser');

    /**
     * @var string
     */
    protected $_resourceUri = '';

    /**
     * This takes a name and breaks it into its individual parts.
     *
     * @param string $name
     * @param string $casing -> valid values are uppercase, lowercase, titlecase
     * @return stdClass
     */
    public function normalizer($name, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/normalizer.json';
        $this->_execute(array('q' => $name, 'method' => 'normalizer', 'casing' => $casing));

        return $this->response_obj;
    }

    /**
     * This resolves a person's name from either their email address or a
     *   username. This is basically a wrapper for the Person lookup methods.
     *
     * @param string $value
     * @param string $type
     * @param string $casing
     * @return stdClass
     */
    public function deducer($value, $type = 'email', $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/deducer.json';
        $this->_execute(array($type => $value, 'method' => 'deducer', 'casing' => $casing));

        return $this->response_obj;
    }

    /**
     * These are two names to compare.
     * 
     * @param string $name1
     * @param string $name2
     * @param string $casing
     * @return stdClass
     */
    public function similarity($name1, $name2, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/similarity.json';
        $this->_execute(array('q1' => $name1, 'q2' => $name2, 'method' => 'similarity', 'casing' => $casing));

        return $this->response_obj;
    }

    /**
     * @param string $value
     * @param string $type
     * @param string $casing
     * @return stdClass
     */
    public function stats($value, $type = 'givenName', $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/stats.json';
        $this->_execute(array($type => $value, 'method' => 'stats', 'casing' => $casing));

        return $this->response_obj;
    }

    /**
     * @param string $name
     * @param string $casing
     * @return stdClass
     */
    public function parser($name, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/parser.json';
        $this->_execute(array('q' => $name, 'method' => 'parser', 'casing' => $casing));

        return $this->response_obj;
    }
}