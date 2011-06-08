<?php
include_once('../src/Rainmaker.php');

//initialize our Rainmaker API object
//get your api key here:  http://rainmaker.cc/api/
$rainmaker = new RainmakerAPI('YOUR_API_KEY_HERE');

//do a lookup
$result = $rainmaker->doLookup('lorangb@gmail.com');

//dump our results
echo "<br/>----------------<br/><pre>";
var_dump($result, true);
echo "</pre><br/>----------------<br/>";
?>