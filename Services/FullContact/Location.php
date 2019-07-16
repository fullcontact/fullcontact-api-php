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
 * This class handles all the Location information
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Location extends Services_FullContact
{
    /**
     * Supported lookup methods
     * @var $_supportedMethods
     */
    protected $_supportedMethods = array('normalizer', 'enrichment');
    protected $_resourceUri = '';

    /**
     * This takes a name and breaks it into its individual parts.
     *
     * @param string $place
     * @param bool $includeZeroPopulation
     * @param string $casing valid values are uppercase, lowercase, titlecase
     * @return stdClass
     */
    public function normalizer($place, $includeZeroPopulation = false, $casing = 'titlecase')
    {
        $includeZeroPopulation = ($includeZeroPopulation) ? 'true' : 'false';

        $this->_resourceUri = '/address/locationNormalizer.json';
        $this->_execute(array('place' => $place, 'includeZeroPopulation' => $includeZeroPopulation,
            'method' => 'normalizer', 'casing' => $casing));

        return $this->response_obj;
    }

    /**
     * @param string $place
     * @param bool $includeZeroPopulation
     * @param string $casing
     * @return stdClass
     */
    public function enrichment($place, $includeZeroPopulation = false, $casing = 'titlecase')
    {
        $includeZeroPopulation = ($includeZeroPopulation) ? 'true' : 'false';

        $this->_resourceUri = '/address/locationEnrichment.json';
        $this->_execute(array('place' => $place, 'includeZeroPopulation' => $includeZeroPopulation,
            'method' => 'enrichment', 'casing' => $casing));

        return $this->response_obj;
    }
}