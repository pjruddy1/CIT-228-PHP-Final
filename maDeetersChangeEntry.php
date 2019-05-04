<?php
session_start();
include 'maDeetersConnect.php';
doDB();

if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select a Guest to Update</h1>";

	//get parts of records
	$get_list_sql = "SELECT master_id,
	                 CONCAT_WS(', ', last_name, first_name) AS display_name
	                 FROM guest_info ORDER BY last_name, first_name";
	$get_list_res = mysqli_query($mysqli, $get_list_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_list_res) < 1) {
		//no records
		$display_block .= "<p><em>Sorry, no records to select!</em></p>";

	} else {
		//has records, so get results and print in a form
		$display_block .= "
		<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
		<p><label for=\"master_id\">Select a Record to Update:</label><br/>
		<select id=\"master_id\" name=\"master_id\" required=\"required\">
		<option value=\"\">-- Select One --</option>";

		while ($recs = mysqli_fetch_array($get_list_res)) {
			$master_id = $recs['master_id'];
			$display_name = stripslashes($recs['display_name']);
			$display_block .= "<option value=\"".$master_id."\">".$display_name."</option>";
		}

		$display_block .= "
		</select></p>
		<button type=\"submit\" name=\"submit\" value=\"change\">Change Selected Entry</button>
		</form>";
	}
	//free result
	mysqli_free_result($get_list_res);

}  if($_POST) {
	//check for required fields
	if ($_POST['master_id'] == "")  {
		header("Location: changeEntry.php");
		exit;
	}

	//create safe version of ID
	$safe_id = mysqli_real_escape_string($mysqli, $_POST['master_id']);
	$_SESSION["master_id"]=$safe_id;
	$_SESSION["address"]="true";	
	$_SESSION["city"]="true";
	$_SESSION["state"]="true";
	$_SESSION["zipcode"]="true";
	$_SESSION["tel_number"]="true";
	$_SESSION["email"]="true";
	$_SESSION["preffered_contact_method"]="true";
	$_SESSION["dollars_spent"]="true";
	$_SESSION["points_earned"]="true";
	//get master_info
	$get_master_sql = "SELECT first_name, last_name, address, city, state, zipcode, tel_number, email, preffered_contact_method
	 FROM guest_info WHERE master_id = '".$safe_id."'";
	$get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));

	while ($guest_info = mysqli_fetch_array($get_master_res)) {
		$display_first_name = stripslashes($guest_info['first_name']);
		$display_last_name = stripslashes($guest_info['last_name']);	
		$display_address = stripslashes($guest_info['address']);
		$display_city = stripslashes($guest_info['city']);
		$display_state = stripslashes($guest_info['state']);
		$display_zipcode = stripslashes($guest_info['zipcode']);	
		$display_tel_number = stripslashes($guest_info['tel_number']);
		$display_email = stripslashes($guest_info['email']);
		$display_preffered_contact_method = $guest_info['preffered_contact_method'];
	}

	$display_block = "<h1>Guest Update</h1>";
	$display_block.="<form method='post' action='guest_change.php'>";
	$display_block.="<fieldset><legend><strong>First/Last Names:</strong></legend>";
	$display_block.="<input type='text' name='first_name' size='20' maxlength='75' required='required' value='" . $display_first_name . "'/>";
	$display_block.="<input type='text' name='last_name' size='30' maxlength='75' required='required' value='" . $display_last_name . "'/></fieldset><p></p>";
	
	$display_block .="<fieldset><legend><strong>Preffered Contact Method:</strong></legend>";

	if ($display_preffered_contact_method=="email"){
		$display_block .="<input type='radio' id='email' name='contact_method' value='email' checked='checked /><label for='email'>email</label></br>";
		$display_block .="<input type='radio' id='phone' name='contact_method' value='phone' /><label for='phone'>phone</label></br>";
		$display_block .="<input type='radio' id='mail' name='contact_method' value='email'/><label for='mail'>mail</label></br><p></p>";;
	}
	else if ($display_preffered_contact_method=="phone"){
		$display_block .="<input type='radio' id='email' name='contact_method' value='email'/><label for='email'>email</label></br>";
		$display_block .="<input type='radio' id='phone' name='contact_method' value='phone' checked='checked/><label for='phone'>phone</label></br>";
		$display_block .="<input type='radio' id='mail' name='contact_method' value='email'/><label for='mail'>mail</label></br><p></p>";;
	}
	else{
		$display_block .="<input type='radio' id='email' name='contact_method' value='email'/><label for='email'>email</label></br>";
		$display_block .="<input type='radio' id='phone' name='contact_method' value='phone'/><label for='phone'>phone</label></br>";
		$display_block .="<input type='radio' id='mail' name='contact_method' value='email' checked='checked/><label for='mail'>mail</label></br><p></p>";;
	}	
	

	$display_block .="<legend><strong>Street Address/City/State/Zip:</strong></legend>";
	$display_block .="<input type='text' id='address' name='address' required='required' size='30' maxlength='50' value='".$display_address."'/></br>";
	$display_block .="<input type='text' name='city' required='required' size='30' maxlength='50' value='" . $display_city . "'/></br>";
	$display_block .="<input type='text' name='state' size='5' required='required' maxlength='2' value='".$display_state."'/></br>";
	$display_block .="<input type='text' name='zipcode' size='10' required='required' maxlength='10' value='".$display_zipcode."'/></br><p></p>";
	

	$display_block .="<legend><strong>Email: </strong></legend>";
	$display_block .="<input type='text' id='email' name='email' required='required' size='25' maxlength='50' value='".$display_email."'/></br>";
	$display_block .="<legend><strong>Phone Number: </legend>";
	$display_block .="<input type='text' name='tel_number' name='tel_number' required='required' size='25' maxlength='50' value='" . $display_tel_number . "'/>";
	$display_block.="</fieldset>";
	
	//free result
	mysqli_free_result($get_master_res);
	//get all addresses
	$get_points_earned_sql = "SELECT points_earned, dollars_spent FROM points_earned WHERE master_id = '".$safe_id."'";
	$get_points_earned_res = mysqli_query($mysqli, $get_points_earned_sql) or die(mysqli_error($mysqli));

 	if (mysqli_num_rows($get_points_earned_res) > 0) {
		while ($reward_info = mysqli_fetch_array($get_points_earned_res)) {
			$points_earned = stripslashes($reward_info['points_earned']);
			$dollars_spent = stripslashes($reward_info['dollars_spent']);
		}		
			
			$display_block.="<fieldset><strong>Rewards</strong>";
			$display_block.="<legend><strong>Points Earned: </strong></legend>";
			$display_block .="<input type='number' name='points_earned'  required='required' size='20' min='0' max='200' value='".$points_earned."'/>";
			$display_block.="<legend><strong>Check Total: </strong></legend>";
			$display_block .="<input type='number' name='dollars_spent'  required='required' size='20' min='0' max='1000' value='".$dollars_spent."'/></p>";
		}
	$display_block .="</fieldset>";
//free result
	mysqli_free_result($get_points_earned_res);
	}	

	$display_block .= "<p style=\"text-align: center\"><button type='submit' name='submitChange' id='submitChange' value='submitChange'>Change Entry</button>";
	$display_block .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href='maDeetersDBMenu.html';>Cancel and return to main menu</a></p></form>";

//close connection to MySQL
mysqli_close($mysqli);

?>
<!DOCTYPE html>
<html>
<head>
<title>Update Guest Info/Rewards</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>