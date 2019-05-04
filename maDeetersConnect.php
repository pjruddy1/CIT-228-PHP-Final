<?php
function doDB() {
	global $mysqli;

	//connect to server and select database; you may need it
	$mysqli = mysqli_connect("localhost", "root", "", "guest_reward_and_review"); //below   try lisabalbach_Ruddy if not connecting
	//$mysqli = mysqli_connect("localhost", "lisabalbach_ruddyp", "CIT19020003", "lisabalbach_Ruddy");

	//if connection fails, stop script execution
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
}
?>