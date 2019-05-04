<?php
$mysqli = mysqli_connect("localhost", "root", "", "guest_reward_and_review");
$guests = file_get_contents("maDeetersGuests.json");

$display="<div id='deetersGuests'><h1>Ma Deeter's Guests</h1>";

   
	$guestObj = json_decode($guests);
	foreach ($guestObj->guest as $g){
	  $first_name = $g->first_name;
	  $last_name = $g->last_name;
		$address = $g->address;
		$city = $g->city;
	  $state = $g->state;
		$zipcode = $g->zipcode;
		$email = $g->email;
	  $tel_number = $g->tel_number;
	  $preffered_contact_method = $g->preffered_contact_method;
			$display.= "<h2>" . $first_name . " " . $last_name . "</h2>" . "<p>Preffered Contact Method: " . $preffered_contact_method . 
            "<br>Address: " . $address . " " . $city . ", " . $state . " " . $zipcode . 
            "<br>Telephone: " . $tel_number . "<br>Email:  " . $email . "</p>";
	 }
	 $display .= "</div>";
	 $display .= "<footer>Would you like to:<br/>	
	...<a href=\"maDeetersDBMenu.html\">goto main menu</a></footer>";
?>

<!DOCTYPE html>
<html>
<head>
<title>Chocolatiers</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php 
echo $display;
?> 
</body>

</html>	 

