<?php
$xmlList = simplexml_load_file("Guests.xml") or die("Error: Cannot create object");

foreach($xmlList->guest as $ng){
    $master_id=$ng->master_id;
    $first_name=$ng->first_name;
    $last_name=$ng->last_name;
    $date_added=$ng->date_added;
    $date_modified=$ng->date_modified;
    $address=$ng->address;
    $city=$ng->city;
    $state=$ng->state;
    $zipcode=$ng->zipcode;
    $email=$ng->email;
    $tel_number=$ng->tel_number;
    $contact_method=$ng->contact_method;



echo "<div><h1>ID: ".$master_id."<br>".
"<span>Name: ".$first_name." ".$last_name."<br>".
"Added: ".$date_added."<br>".
"Address: ".$address."<br>".
"City: ".$city."<br>".
"State: ".$state."<br>".
"Zipcode: ".$zipcode."<br>".
"Email: ".$email."<br>".
"Telephone: ".$tel_number."</h1></div>";


}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Guest XML</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
</body>
</html>