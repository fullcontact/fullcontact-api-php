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
        $this->_execute(array('email' => $search, 'lookup' => 'email'));

        return $this->response_obj;
    }

    public function lookupByPhone($search)
    {
        $this->_execute(array('phone' => $search, 'lookup' => 'phone'));

        return $this->response_obj;
    }

    public function lookupByTwitter($search)
    {
        $this->_execute(array('twitter' => $search, 'lookup' => 'twitter'));

        return $this->response_obj;
    }

    public function lookupByFacebook($search)
    {
        $this->_execute(array('facebookUsername' => $search, 'lookup' => 'facebookUsername'));

        return $this->response_obj;
    }

    /**
     * This is a pretty close copy of my work on the Contactually PHP library
     *   available here: http://github.com/caseysoftware/contactually-php
     *
     * @author  Keith Casey <contrib@caseysoftware.com>
     * @param   array $params
     * @return  object
     * @throws  Services_FullContact_Exception_NotImplemented
     */
    protected function _execute($params = array())
    {
        if(!in_array($params['lookup'], $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ .
                    " does not support the [" . $params['lookup'] . "] lookup method");
        }

        $params['apiKey'] = urlencode($this->_apiKey);

        $fullUrl = $this->_baseUri . $this->_version . $this->_resourceUri .
                '?' . http_build_query($params);

        //open connection
        $connection = curl_init($fullUrl);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_USERAGENT, self::USER_AGENT);

        //execute request
        $this->response_json = curl_exec($connection);
        $this->response_code = curl_getinfo($connection, CURLINFO_HTTP_CODE);
        $this->response_obj  = json_decode($this->response_json);

        return $this->response_obj;
    }
}