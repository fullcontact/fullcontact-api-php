<?php

/**
 * This class just tells us what icons we have available
 *
 * @package  Services\FullContact
 * @author   Keith Casey <contrib@caseysoftware.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache
 */
class Services_FullContact_Icon extends Services_FullContact
{
    protected $_supportedMethods = array('available');
    protected $_resourceUri = '/icon/';

    public function available()
    {
        $this->_execute(array('method' => 'available'));

        return $this->response_obj;
    }
}