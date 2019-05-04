<?php
include 'maDeetersConnect.php';
//include 'maDeetersSelect.php';
doDB();

//
//Using Guests master_id fill out form
// master_id Is found from the maDeetersSelect.php

if (!$_POST)  {
	
	$display_block = <<<END_OF_BLOCK
	<form method="post" action="$_SERVER[PHP_SELF]">
	<h1>All Properties Must Be Filled</h1>
	<fieldset>
	<legend>Guest ID:</legend><br/>
	<input type="text" name="master_id" required="required" size="30" maxlength="6"/>
	</fieldset>

	<fieldset>
	<legend>Points Earned this Visit/ Check Total this Visit:</legend>
	<input type="number" name="points_earned" required="required" size="20" min="1" max="200"/>
	<input type="number" name="dollars_spent" required="required" size="20" min="1" max="1000"/>
	</fieldset>	

	<button type="submit" name="submit" value="send">Add Entry</button>
	</form>
END_OF_BLOCK;


} else if ($_POST) {
	//time to add to tables, so check for required fields
	//if (($_POST['first_name'] == "") || ($_POST['last_name'] == "")) {
		//header("Location: maDeetersReview.php");
		//exit;
	//}

	//connect to database
	//doDB();

	//create clean versions of input strings
	//$safe_f_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
	//$safe_l_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
	
	$master_id = mysqli_real_escape_string($mysqli, $_POST['master_id']);
	$safe_points_earned = mysqli_real_escape_string($mysqli,$_POST['points_earned']);
	$safe_dollars_spent = mysqli_real_escape_string($mysqli,$_POST['dollars_spent']);;

	

	if (($_POST['points_earned'])) {
		//something relevant, so add to address table
		$add_points_sql = "INSERT INTO points_earned (master_id, date_added, date_modified, points_earned, dollars_spent)
							 VALUES ('".$master_id."', now(), now(), '".$safe_points_earned."', '".$safe_dollars_spent."')";
		$add_points_res = mysqli_query($mysqli, $add_points_sql) or die(mysqli_error($mysqli));
	}

	mysqli_close($mysqli);
	$display_block= "<footer>Your entry has been added.  Would you like to:<br/>
	<a href=\"".$_SERVER['PHP_SELF']."\">Add More Rewards</a>
	...<a href=\"maDeetersReview.php\">Add Food Review</a>
	...<a href=\"maDeetersServiceReview.php\">Add Service Review</a><br/>
	...<a href=\"maDeetersSelect2.php\">Select New Guest</a>...<a href=\"maDeetersAddGuest.php\">Add A Guest</a>
	...<a href=\"maDeetersDBMenu.html\">main menu</a></footer>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Guest Rewards</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h1>Add Guest Rewards</h1>
<?php echo $display_block; ?>
</body>
</html>