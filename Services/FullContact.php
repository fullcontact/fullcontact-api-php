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

define ("FC_BASE_URL", "https://api.fullcontact.com/");
define ("FC_API_VERSION", "v2");
define ("FC_USER_AGENT", "caseysoftware/fullcontact-php 0.1");

/**
 * This class doesn't do much yet..
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact
{
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
     * @access protected
     *
     * @param type $json_endpoint
     * @return boolean
     * @throws Exception
     */
    protected function _restHelper($json_endpoint)
    {

        $return_value = null;

        $http_params = array(
            'http' => array(
                'method' => "GET",
                'ignore_errors' => true
        ));

        $curl = curl_init($json_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, FC_USER_AGENT);

        $response = curl_exec($curl);

        if ($response) {
            //Save the response code in case of error
            $curl_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $this->response_code = $curl_response_code;
            $this->response_json = $response;
            $this->response_obj  = json_decode($this->response_json);

            //We're receiving stream data back from the API, json decode it here.
            $result = json_decode($response, true);

            //if result is NULL we have some sort of error
            if ($result === null) {
                $return_value = array();
                $return_value['is_error'] = true;

                if (strpos($curl_response_code, "403") !== false) {
                    $return_value['error_message'] = "Your API key is invalid, missing, or has exceeded its quota.";

                } else if (strpos($curl_response_code, "422") !== false) {
                    $return_value['error_message'] = "The server understood the content type and syntax of the request but was unable to process the contained instructions (Invalid email).";
                }

            } else {
                $result['is_error'] = false;
                $return_value = $result;
            }// end inner else

        } else {
            throw new Exception("$verb $json_endpoint failed");
        }//end outer else

        curl_close($curl);

        return $return_value;
    }//end restHelper
}