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
 * This class just tells us what icons we have available
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Stats extends Services_FullContact
{
    protected $_supportedMethods = array('retrieve');
    protected $_resourceUri = '/stats.json';

    public function retrieve($period = null)
    {
    	if (is_null($period)) {
            throw new Services_FullContact_Exception_Base("To retrieve stats, you must supply a period date.");
        }
        if (self::validatePeriod($period)) {
            return $this->_execute(array('period' => $period, 'method' => 'retrieve'));
        } 
        else {
            throw new Services_FullContact_Exception_Base("The period date is not well formated. Please provide the following format YYYY-MM.");
        }

    }

    public function validatePeriod($date)
    {
        $format = DateTime::createFromFormat('Y-m', $date);
        return $format && $format->format('Y-m') == $date;
    }
}