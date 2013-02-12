<?php
/*
Copyright 2012 FullContact, Inc.
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 */
define ("BASE_URL", "https://api.fullcontact.com/");
define ("API_VERSION", "v2");

class FullContactAPI {

    private $_apiKey = null;

    /*
     *
     * @param String $token_id
     *
     */
    public function __construct($api_key) {
        $this->_apiKey = $api_key;
    }

    /*
     * Return an array of data about a specific email address
     *
     * @param String - Email address
     * @param String (optional, depcrecated) - timeout
     *
     * @return Array - All information associated with this email address
     */
    public function doLookup($email = null, $timeout = 0) {
        $return_value = null;

        if ($email != null) {

            $url = BASE_URL . API_VERSION . "/person.json?email=" . urlencode($email) . "&apiKey=" . urlencode($this->_apiKey);
            if ($timeout > 0) {
                $url .= "&timeoutSeconds=" . urlencode($timeout);
            }
            $result = $this->restHelper($url);

            if ($result != null) {
                $return_value = $result;
            }//end inner if
        }//end outer if

        return $return_value;
    }

/****************************************************************************/
/****************************************************************************/

    /*********************************
     **** PRIVATE helper function ****
     *********************************/
    function restHelper($json_endpoint) {

        $return_value = null;

        $http_params = array(
            'http' => array(
                'method' => "GET",
                'ignore_errors' => true
        ));

        $curl = curl_init($json_endpoint);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);

        if ($response) {
            //Save the response code in case of error
            $curl_response_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

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
}//end FullContactAPI
?>
