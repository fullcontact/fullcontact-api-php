<?php

/**
 * This class handles everything related to the Person lookup API.
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Person extends Services_FullContact
{
    /**
     * Supported lookup methods
     * @var $_supportedMethods
     */
    private $_supportedMethods = array('email', 'phone', 'twitter', 'facebookUsername');
    protected $_resourceUri = '/person.json';

    public function lookupByEmail($email)
    {
        $this->doLookup($email, 'email');

        return $this->response_obj;
    }

    public function lookupByPhone($phone)
    {
        $this->doLookup($phone, 'phone');

        return $this->response_obj;
    }

    public function lookupByTwitter($twitter)
    {
        $this->doLookup($twitter, 'twitter');

        return $this->response_obj;
    }

    public function lookupByFacebook($facebook)
    {
        $this->doLookup($facebook, 'facebookUsername');

        return $this->response_obj;
    }

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
    protected function doLookup($term = null, $type="email", $timeout = 30)
    {
        if(!in_array($type, $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ . " does not support the [{$method}] method");
        }

        $return_value = null;

        if ($term != null) {

            $result = $this->_restHelper($this->_resourceUri . "?{$type}=" . urlencode($term) . "&apiKey=" . urlencode($this->_apiKey));

            if ($result != null) {
                $return_value = $result;
            }//end inner if
        }//end outer if

        return $return_value;
    }
}