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
    protected $_supportedMethods = array('email', 'phone', 'twitter', 'facebookUsername');
    protected $_resourceUri = '/person.json';

    public function lookupByEmail($search)
    {
        $this->_execute(array('email' => $search, 'method' => 'email'));

        return $this->response_obj;
    }

    public function lookupByPhone($search)
    {
        $this->_execute(array('phone' => $search, 'method' => 'phone'));

        return $this->response_obj;
    }

    public function lookupByTwitter($search)
    {
        $this->_execute(array('twitter' => $search, 'method' => 'twitter'));

        return $this->response_obj;
    }

    public function lookupByFacebook($search)
    {
        $this->_execute(array('facebookUsername' => $search, 'method' => 'facebookUsername'));

        return $this->response_obj;
    }
}