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

	<fieldset>
	<legend>Guest ID:</legend><br/>
	<input type="text" name="master_id" size="30" maxlength="6" required="required" />
	</fieldset>

	<fieldset>
	<legend>Where You Greeted At the Door within One Minute:</legend><br/>
	<input type="text" name="greeted_at_door" size="30" maxlength="3" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Server Timeliness/ Friendliness/ Server Appearance (1"poor"-10"great"):</legend><br/>
	<input type="number" name="server_timeliness" size="15" min="1" max="10" required="required"/>
	<input type="number" name="server_friendliness" size="15" min="1" max="10" required="required"/>
	<input type="number" name="server_appearance" size="15" min="1" max="10" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Food Temperature/  Amount of Time From Ordering till Receiving Food(mins):</legend><br/>
	<input type="number" name="food_temp" size="15" min="1" max="10" required="required"/>
	<input type="number" name="food_delivery_time_mins" size="15" min="1" max="120" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Restaurant/  Bathroom Cleanliness:</legend><br/>
	<input type="number" name="resteraunt_cleanliness" size="15" min="1" max="10" required="required"/>
	<input type="number" name="bathroom_cleanliness" size="15" min="1" max="10" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Additional Comments:</legend><br/>
    <textarea id="note" name="additional_comments" cols="35" rows="3"></textarea></p>
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
	$greeted_at_door = mysqli_real_escape_string($mysqli,$_POST['greeted_at_door']);
	$server_timeliness = mysqli_real_escape_string($mysqli,$_POST['server_timeliness']);
	$server_friendliness = mysqli_real_escape_string($mysqli,$_POST['server_friendliness']);
	$server_appearance = mysqli_real_escape_string($mysqli,$_POST['server_appearance']);
	$food_temp = mysqli_real_escape_string($mysqli,$_POST['food_temp']);
	$food_delivery_time_mins = mysqli_real_escape_string($mysqli,$_POST['food_delivery_time_mins']);
	$resteraunt_cleanliness = mysqli_real_escape_string($mysqli, $_POST['resteraunt_cleanliness']);
	$bathroom_cleanliness = mysqli_real_escape_string($mysqli,$_POST['bathroom_cleanliness']);
	$additional_comments = mysqli_real_escape_string($mysqli,$_POST['additional_comments']);


	//if , additional_comments is not filled then not data will be entered
	if($_POST['additional_comments']==""){
		$add_review_sql = "INSERT INTO guest_service_review (master_id, date_added, greeted_at_door, server_timeliness, server_friendliness,
							server_appearance, food_temp, food_delivery_time_mins, resteraunt_cleanliness, bathroom_cleanliness)  VALUES 
                            ('".$master_id."', now(), '".$greeted_at_door."', '".$server_timeliness."',
							 '".$server_friendliness."', '".$server_appearance."', '".$food_temp."', '".$food_delivery_time_mins."',
							 '".$resteraunt_cleanliness."', '".$bathroom_cleanliness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}else{
		$add_review_sql = "INSERT INTO guest_service_review (master_id, date_added, greeted_at_door, server_timeliness, server_friendliness,
							server_appearance, food_temp, food_delivery_time_mins, resteraunt_cleanliness, bathroom_cleanliness, additional_comments)  VALUES 
                            ('".$master_id."', now(), '".$greeted_at_door."', '".$server_timeliness."',
							 '".$server_friendliness."', '".$server_appearance."', '".$food_temp."', '".$food_delivery_time_mins."',
							 '".$resteraunt_cleanliness."', '".$bathroom_cleanliness."', '".$additional_comments."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}


	mysqli_close($mysqli);
	$display_block= "<footer>Your entry has been added.  Would you like to:<br/>
	<a href=\"maDeetersReward.php\">Add Rewards</a>
	...<a href=\"maDeetersReview.php\">Add A Food Review</a>
	...<a href=\"".$_SERVER['PHP_SELF']."\">Add Another Service Review</a><br/>
	...<a href=\"maDeetersSelect2.php\">select A Guest</a>...<a href='maDeetersAddGuest.php'>Add A Guest</a>
	...<a href='maDeetersDBMenu.html'>main menu</a></footer>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Service Review</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h1>Add A Service Review</h1>
<?php echo $display_block; ?>
</body>
</html>