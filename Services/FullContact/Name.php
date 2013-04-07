<?php

/**
 * This class doesn't do much yet..
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
    private $_supportedMethods = array('normalizer', 'deducer', 'similarity', 'stats', 'parser');

    public function normalize($name, $casing = 'titlecase')
    {
        $this->runQuery($name, 'normalizer', 'q', $casing);

        return $this->response_obj;
    }

    public function deducer($name) { }
    public function similarity($name) { }
    public function stats($name) { }
    public function parser($name) { }

    /**
     * Return an array of data about a specific email address/phone number
     *   -- Mario Falomir http://github.com/mariofalomir
     *
     * @param String - Search Term (Could be an email address or a phone number,
     *   depending on the specified search type)
     * @param String - Search Type (Specify the API search method to use.
     *   E.g. email -- tested with email and phone)
     * @param String (optional) - timeout
     *
     * @return Array - All information associated with this email address
     */
    protected function runQuery($term = null, $method = 'normalizer', $search = "email", $casing = 'titlecase')
    {
        if(!in_array($method, $this->_supportedMethods)){
            throw new Services_FullContact_Exception_Base("UnsupportedLookupMethodException: Invalid lookup method specified [{$method}]");
        }

        $return_value = null;

        if ($term != null) {

            $result = $this->_restHelper(FC_BASE_URL . FC_API_VERSION . "/name/" . $method . ".json?{$search}=" . urlencode($term) . "&apiKey=" . urlencode($this->_apiKey));

            if ($result != null) {
                $return_value = $result;
            }//end inner if
        }//end outer if

        return $return_value;
    }
}