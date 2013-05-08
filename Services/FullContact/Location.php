<?php

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
     * @param type $name
     * @param type $casing -> valid values are uppercase, lowercase, titlecase
     * @return type
     */
    public function normalizer($place, $includeZeroPopulation = false, $casing = 'titlecase')
    {
        $includeZeroPopulation = ($includeZeroPopulation) ? 'true' : 'false';

        $this->_resourceUri = '/address/locationNormalizer.json';
        $this->_execute(array('place' => $place, 'includeZeroPopulation' => $includeZeroPopulation,
            'method' => 'normalizer', 'casing' => $casing));

        return $this->response_obj;
    }

    public function enrichment($place, $includeZeroPopulation = false, $casing = 'titlecase')
    {
        $includeZeroPopulation = ($includeZeroPopulation) ? 'true' : 'false';

        $this->_resourceUri = '/address/locationEnrichment.json';
        $this->_execute(array('place' => $place, 'includeZeroPopulation' => $includeZeroPopulation,
            'method' => 'enrichment', 'casing' => $casing));

        return $this->response_obj;
    }
}