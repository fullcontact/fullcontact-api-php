<?php

include_once '../creds.php';
include_once '../Services/FullContact.php';

//initialize our FullContact API object
//get your api key here:  http://fullcontact.com/getkey
$fullcontact = new Services_FullContact_API($apikey);

//do a lookup
$result = $fullcontact->doLookup('bart@fullcontact.com');

//dump our results
echo "<br/>----------------<br/><pre>";
print_r($result);
echo "</pre><br/>----------------<br/>\n";
