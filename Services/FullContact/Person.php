<?php

/**
 * This class doesn't do much yet..
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Person extends FullContactAPI
{
    public $response_obj  = null;
    public $response_code = null;
    public $response_json = null;

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
}