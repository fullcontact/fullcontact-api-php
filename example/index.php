<?php

include_once 'creds.php';
include_once('../src/FullContact.php');

//initialize our FullContact API object
//get your api key here:  http://fullcontact.com/getkey
$fullcontact = new FullContactAPI($apikey);

//do a lookup
$result = $fullcontact->doLookup('bart@fullcontact.com');

//dump our results
echo "<br/>----------------<br/><pre>";
print_r($result);
echo "</pre><br/>----------------<br/>\n";
