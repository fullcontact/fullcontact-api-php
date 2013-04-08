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

    /**
     * This takes a name and breaks it into its individual parts.
     *
     * @param type $name
     * @param type $casing -> valid values are uppercase, lowercase, titlecase
     * @return type
     */
    public function normalize($name, $casing = 'titlecase')
    {
        $this->runQuery($name, 'normalizer', 'q', $casing);

        return $this->response_obj;
    }

    /**
     * This resolves a person's name from either their email address or a
     *   username. This is basically a wrapper for the Person lookup methods.
     *
     * @param type $name
     * @param type $type -> valid values are email and username
     * @param type $casing -> valid values are uppercase, lowercase, titlecase
     * @return type
     */
    public function deducer($value, $type = 'email', $casing = 'titlecase')
    {
        $this->runQuery($value, 'deducer', $type, $casing);

        return $this->response_obj;
    }

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
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ . " does not support the [{$method}] method");
        }

        $return_value = null;

        if ($term != null) {

            $result = $this->_restHelper($this->_baseUri . $this->_version . "/name/" . $method . ".json?{$search}=" . urlencode($term) .
                    "&casing=" . $casing . "&apiKey=" . urlencode($this->_apiKey));

            if ($result != null) {
                $return_value = $result;
            }//end inner if
        }//end outer if

        return $return_value;
    }
}