<?php
session_start();
//connect to database
include 'maDeetersConnect.php';

//time to update tables, so check for required fields
	if (($_POST['first_name'] == "") || ($_POST['last_name'] == "")) {
		header("Location: maDeetersChangeEntry.php");
		exit;
	}
	//connect to database
	doDB();
	//create clean versions of input strings
	$master_id=$_SESSION["master_id"];
	$safe_first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
	$safe_last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
	$safe_address = mysqli_real_escape_string($mysqli, $_POST['address']);
	$safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
	$safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
	$safe_zipcode = mysqli_real_escape_string($mysqli, $_POST['zipcode']);
	$safe_tel_number = mysqli_real_escape_string($mysqli, $_POST['tel_number']);	
	$safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $safe_points_earned = mysqli_real_escape_string($mysqli, $_POST['points_earned']);
    $safe_dollars_spent = mysqli_real_escape_string($mysqli, $_POST['dollars_spent']);
	
	//update guest_info table
    $add_master_sql = "UPDATE guest_info SET date_modified=now(),first_name='".$safe_first_name."',last_name='". $safe_last_name."',
                            first_name='".$safe_first_name."',last_name='". $safe_last_name."',address='".$safe_address."',city='".$safe_city."',
														state='".$safe_state."',zipcode='".$safe_zipcode."',tel_number='".$safe_tel_number."',email='".$safe_email."',
														 preffered_contact_method='".$_POST['contact_method']."'".
	                   "WHERE master_id=".$master_id;
	$add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));

	if (($_SESSION["points_earned"]=="true")&&($_SESSION["dollars_spent"]=="true")){
		//update rewards and dollar spent table
		$add_reward_sql = "UPDATE points_earned SET master_id=".$master_id.",date_modified=now()".
							",points_earned='". $safe_points_earned ."', dollars_spent='". $safe_dollars_spent ."'".
							 "WHERE master_id=".$master_id;
		$add_reward_res = mysqli_query($mysqli, $add_reward_sql) or die(mysqli_error($mysqli));
		}
	 

	mysqli_close($mysqli);
	$display_block = "<footer>Your entry has been Changed.  Would you like to:<br/>
	<a href=\"maDeetersReward.php\">Add Rewards</a>
	...<a href=\"maDeetersReview.php\">Add A Food Review</a>
	...<a href=\"maDeetersServiceReview.php\">Add A Service Review</a><br/>
	...<a href=\"maDeetersSelect2.php\">select A Guest</a>
	...<a href=\"".$_SERVER['PHP_SELF']."\">Edit Another Guest</a>
	...<a href=\"maDeetersAddGuest.php\">Add A Guest</a>
	...<a href=\"maDeetersDBMenu.html\">main menu</a></footer>";

?>
<!DOCTYPE html>
<html>
<head>
<title>Guest Info And Reward Update</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>