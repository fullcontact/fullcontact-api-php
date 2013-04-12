<?php

include_once '../creds.php';
include_once '../Services/FullContact.php';

$fullcontact = new Services_FullContact_Person($apikey);

//do a lookup
$result = $fullcontact->lookupByEmail('bart@fullcontact.com');

//dump our results
echo "<br/>----------------<br/><pre>";
print_r($result);
echo "</pre><br/>----------------<br/>\n";