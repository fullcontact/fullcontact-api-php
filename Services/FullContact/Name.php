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
    protected $_supportedMethods = array('normalizer', 'deducer', 'similarity', 'stats', 'parser');
    protected $_resourceUri = '';

    /**
     * This takes a name and breaks it into its individual parts.
     *
     * @param type $name
     * @param type $casing -> valid values are uppercase, lowercase, titlecase
     * @return type
     */
    public function normalize($name, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/normalizer.json';
        $this->_execute(array('q' => $name, 'method' => 'normalizer', 'casing' => $casing));

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
        $this->_resourceUri = '/name/deducer.json';
        $this->_execute(array($type => $value, 'method' => 'deducer', 'casing' => $casing));

        return $this->response_obj;
    }

    public function similarity($name) { }
    public function stats($name) { }
    public function parser($name) { }

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
        if(!in_array($params['method'], $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ .
                    " does not support the [" . $params['method'] . "] lookup method");
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