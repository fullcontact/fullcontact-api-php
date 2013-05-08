<?php

/**
 * This class handles everything related to names that aren't person-based info lookup
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
    public function normalizer($name, $casing = 'titlecase')
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

    /**
     * These are two names to compare.
     * 
     * @param type $name1
     * @param type $name2
     * @param type $casing
     * @return type 
     */
    public function similarity($name1, $name2, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/similarity.json';
        $this->_execute(array('q1' => $name1, 'q2' => $name2, 'method' => 'similarity', 'casing' => $casing));

        return $this->response_obj;
    }

    public function stats($value, $type = 'givenName', $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/stats.json';
        $this->_execute(array($type => $value, 'method' => 'stats', 'casing' => $casing));

        return $this->response_obj;
    }
    public function parser($name, $casing = 'titlecase')
    {
        $this->_resourceUri = '/name/parser.json';
        $this->_execute(array('q' => $name, 'method' => 'parser', 'casing' => $casing));

        return $this->response_obj;
    }
}