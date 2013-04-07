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
    public $response_obj  = null;
    public $response_code = null;
    public $response_json = null;

    
}