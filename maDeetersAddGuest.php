<?php
include 'maDeetersConnect.php';

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_BLOCK
	<form method="post" action="$_SERVER[PHP_SELF]">
	<h1><strong>All Fields Must Be Filled</strong></h1>
	<fieldset>
	
	<legend>First/Last Names:</legend><br/>
	<input type="text" name='first_name' size="20" maxlength="75" required="required" />
	<input type="text" name='last_name' size="30" maxlength="75" required="required" />
	</fieldset>

	<fieldset>
    <legend>Address/City/State/Zip:</legend><br/>
    <input type="text" id="address" name="address" size="30" maxlength="60" required="required"/>
	<input type="text" name="city" size="30" maxlength="50" required="required"/>
	<input type="text" name="state" size="5" maxlength="2" required="required"/>
	<input type="text" name="zipcode" size="10" maxlength="10" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Telephone Number:</legend><br/>
	<input type="text" name="tel_number" size="30" maxlength="25" required="required"/>
	</fieldset>	

	<fieldset>
	<legend>Email Address:</legend><br/>
	<input type="email" name="email" size="30" maxlength="150" required="required"/>	
    </fieldset>
    
    <fieldset>
	<legend>Preffered Method of Contact:</legend><br/>
	<input type="radio" id="email" name="contact_method" value="email" checked />
	    <label for="email">email</label>
	<input type="radio" id="mail" name="contact_method" value="mail" />
	    <label for="mail">mail</label>
	<input type="radio" id="phone" name="contact_method" value="phone" />
	    <label for="phone">text message</label>
    </fieldset>

	<button type="submit" name="submit" value="send">Add Entry</button>
	</form>
END_OF_BLOCK;

} else if ($_POST) {
	//time to add to tables, so check for required fields
	if (($_POST['first_name'] == "") || ($_POST['last_name'] == "")) {
		header("Location: maDeetersAddGuest.php");
		exit;
	}

	//connect to database
	doDB();

	//create clean versions of input strings
	$safe_f_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
	$safe_l_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
	$safe_address = mysqli_real_escape_string($mysqli, $_POST['address']);
	$safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
	$safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
	$safe_zipcode = mysqli_real_escape_string($mysqli, $_POST['zipcode']);
	$safe_tel_number = mysqli_real_escape_string($mysqli, $_POST['tel_number']);
    $safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);


	//add to master_name table
	$add_master_sql = "INSERT INTO guest_info (date_added, date_modified, first_name, last_name, address, city, state, zipcode, tel_number, email, preffered_contact_method)
                       VALUES (now(), now(),'".$safe_f_name."','".$safe_l_name."',
                       '".$safe_address."', '".$safe_city."', '".$safe_state."' , '".$safe_zipcode."',
                       '".$safe_tel_number."', '".$safe_email."', '".$_POST['contact_method']."')";
	$add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));

	//get master_id for use with other tables
	$master_id = mysqli_insert_id($mysqli);

	mysqli_close($mysqli);
	$display_block = "<footer>Your entry has been added.  Would you like to:<br/>
	<a href=\"maDeetersReward.php\">Add Rewards</a>
	...<a href=\"maDeetersReview.php\">Add A Food Review</a>
	...<a href=\"maDeetersServiceReview.php\">Add A Service Review</a><br/>
	...<a href=\"maDeetersSelect2.php\">select A Guest</a>
	...<a href=\"".$_SERVER['PHP_SELF']."\">Add Another Guest</a>
	...<a href=\"maDeetersDBMenu.html\">main menu</a></footer>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Ma Deeter's Guest Entry</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h1>Ma Deeter's Guest Entry</h1>
<?php echo $display_block; ?>
</body>
</html>