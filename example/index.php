<?php
include_once('../src/FullContact.php');

//initialize our FullContact API object
//get your api key here:  http://fullcontact.com/getkey
$fullcontact = new FullContactAPI('YOUR_API_KEY_HERE');

//do a lookup
$result = $fullcontact->doLookup('bart@fullcontact.com');

//dump our results
echo "<br/>----------------<br/><pre>";
var_dump($result, true);
echo "</pre><br/>----------------<br/>";
?>