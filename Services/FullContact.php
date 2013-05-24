<?php

function Services_FullContact_autoload($className) {
    $library_name = 'Services_FullContact';
    
    if (substr($className, 0, strlen($library_name)) != $library_name) {
        return false;
    }
    $file = str_replace('_', '/', $className);
    $file = str_replace('Services/', '', $file);
    return include dirname(__FILE__) . "/$file.php";
}

spl_autoload_register('Services_FullContact_autoload');

/**
 * This class handles the actually HTTP request to the FullContact endpoint.
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact
{
    const USER_AGENT = 'caseysoftware/fullcontact-php-0.2';

    protected $_baseUri = 'https://api.fullcontact.com/';
    protected $_version = 'v2';

    protected $_apiKey = null;

    public $response_obj  = null;
    public $response_code = null;
    public $response_json = null;

    /**
     * The base constructor needs the API key available from here:
     * http://fullcontact.com/getkey
     *
     * @param type $api_key
     */
    public function __construct($api_key)
    {
        $this->_apiKey = $api_key;
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
        if(!in_array($params['method'], $this->_supportedMethods)){
            throw new Services_FullContact_Exception_NotImplemented(__CLASS__ .
                    " does not support the [" . $params['method'] . "] method");
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

        if ('403' == $this->response_code) {
            throw new Services_FullContact_Exception_NoCredit($this->response_obj->message);
        }

        return $this->response_obj;
    }
}

class FullContactAPI extends Services_FullContact_Person
{
    public function __construct($api_key)
    {
        parent::__construct($api_key);
        trigger_error("The FullContactAPI class has been deprecated. Please use Services_FullContact instead.", E_USER_NOTICE);
    }

    /**
     * Instead of using this implementation, you should create a
     *   Services_FullContact_Person class and use the lookup method you prefer.
     *
     * @deprecated
     *
     * @param String - Search Term (Could be an email address or a phone number,
     *   depending on the specified search type)
     * @param String - Search Type (Specify the API search method to use.
     *   E.g. email -- tested with email and phone)
     * @param String (optional) - timeout
     *
     * @return Array - All information associated with this email address
     */
    public function doLookup($search = null, $type="email", $timeout = 30)
    {
        if (is_null($search)) {
            throw new Services_FullContact_Exception_Base("To search, you must supply a search term.");
        }
 
        switch($type)
        {
            case 'email':
                $this->lookupByEmail($search);
                break;
            case 'phone':
                $this->lookupByPhone($search);
                break;
            case 'twitter':
                $this->lookupByTwitter($search);
                break;
            case 'facebookUsername':
                $this->lookupByFacebook($search);
            default:
                throw new FullContactAPIException("UnsupportedLookupMethodException: Invalid lookup method specified [{$type}]");
                break;
        }

        $result = json_decode($this->response_json, true);
        $result['is_error'] = !in_array($this->response_code, array(200, 201, 204));

        return $result;
    }
}