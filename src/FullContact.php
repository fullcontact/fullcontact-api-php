<?php
/*
 * PUT LICENSE HERE
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
    * Return an array of data about a specific email address/phone number -- Mario Falomir http://github.com/mariofalomir
    *
    * @param String - Search Term (Could be an email address or a phone number, depending on the specified search type)
    * @param String - Search Type (Specify the API search method to use. E.g. email -- tested with email and phone)
    * @param String (optional) - timeout
    *
    * @return Array - All information associated with this email address
    */
    public function doLookup($term = null, $type="email", $timeout = 30) {
        $return_value = null;

        if ($term != null) {

            $result = $this->restHelper(BASE_URL . API_VERSION . "/person.json?{$type}=" . urlencode($term) . "&apiKey=" . urlencode($this->_apiKey) . "&timeoutSeconds=" . urlencode($timeout));

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

        $stream_context = stream_context_create($http_params);
        $file_pointer = fopen($json_endpoint, 'rb', false, $stream_context);
        if (!$file_pointer) {
            $stream_contents = false;
        } else {

            $stream_meta_data = stream_get_meta_data($file_pointer);
            $stream_contents = stream_get_contents($file_pointer);
        }
        if ($stream_contents !== false) {

            if (strlen($stream_contents) > 0) {

                //We're receiving stream data back from the API, json decode it here.                
                $result = json_decode($stream_contents, true);

                //if result is NULL we have some sort of error
                if ($result === null) {

                    $return_value = array();
                    $return_value['is_error'] = true;

                    //does the stream meta data give us something to go on?
                    if (isset($stream_meta_data['wrapper_data'][0])) {

                        $return_value['http_header_error_message'] = $stream_meta_data['wrapper_data'][0];
                        /*
                         * IN this case the response status (422 or 403) is in the stream_meta_data 
                         * object.  We'll grab it and return it to the user.
                         *
                         * This occurs if:
                         *  -Invalid email address
                         *  -Invalid or over limit API key
                         */
                        if (strpos($stream_meta_data['wrapper_data'][0], "403") !== false) {
                            $return_value['error_message'] = "Your API key is invalid, missing, or has exceeded its quota.";

                        } else if (strpos($stream_meta_data['wrapper_data'][0], "422") !== false) {
                            $return_value['error_message'] = "The server understood the content type and syntax of the request but was unable to process the contained instructions (Invalid email).";
                        }
                    }//end if (isset)

                } else {

                    $result['is_error'] = false;
                    $return_value = $result;
                }
            }//end if (strlen)

            //The stream_contents failed.
        } else {
            throw new Exception("$verb $json_endpoint failed");
        }//end outer else

        return $return_value;
    }//end restHelper
}//end FullContactAPI
?>
