<?php
include 'maDeetersConnect.php';
doDB();
$myfile = fopen("maDeetersGuests.json", "w") or die("Unable to open file!");
$printString = json_encode($guests);
fwrite($myfile, $printString);
echo "The json Guests file has been created";
fclose($myfile);
?>