<?php

include_once '../creds.php';
include_once '../Services/FullContact.php';

$fullcontact = new Services_FullContact_Person($apikey);

$emailMD5 = md5('bart@fullcontact.com');

//do a lookup
$result = $fullcontact->lookupByEmailMD5($emailMD5);

//dump our results
echo "<br/>----------------<br/><pre>";
print_r($result);
echo "</pre><br/>----------------<br/>\n";