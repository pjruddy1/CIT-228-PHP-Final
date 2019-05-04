<?php
include 'maDeetersConnect.php';
doDB();

if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select an Entry</h1>";

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
		<p><label for=\"sel_id\">Select a Guest:</label><br/>
		<select id=\"sel_id\" name=\"sel_id\" required=\"required\">
		<option value=\"\">-- Select One --</option>";

		while ($recs = mysqli_fetch_array($get_list_res)) {
			$id = $recs['master_id'];
			$display_name = stripslashes($recs['display_name']);
			$display_block .= "<option value=\"".$id."\">".$display_name."</option>";
		}

		$display_block .= "
		</select></p>
		<button type=\"submit\" name=\"submit\" value=\"view\">View Selected Entry</button>
		</form>";
	}
	//free result
	mysqli_free_result($get_list_res);

} else if ($_POST) {
	//check for required fields
	if ($_POST['sel_id'] == "")  {
		header("Location: selentry.php");
		exit;
	}

	//create safe version of ID
	$safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);

	//get master_info
	$get_master_sql = "SELECT concat_ws(' ', first_name, last_name) as display_name
	                   FROM guest_info WHERE master_id = '".$safe_id."'";
	$get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));

	while ($name_info = mysqli_fetch_array($get_master_res)) {
		$display_name = stripslashes($name_info['display_name']);
	}

	$display_block = "<h1>Guest: ".$display_name.", ID:".$safe_id."</h1>";

	//free result
	mysqli_free_result($get_master_res);

	//get all addresses
	$get_addresses_sql = "SELECT address, city, state, zipcode, tel_number, email, preffered_contact_method
	                      FROM guest_info WHERE master_id = '".$safe_id."'";
	$get_addresses_res = mysqli_query($mysqli, $get_addresses_sql) or die(mysqli_error($mysqli));

 	if (mysqli_num_rows($get_addresses_res) > 0) {

		$display_block .= "<p><strong>Guest Info and Contact Prefferance:</strong><br/>
		<ul>";

		while ($add_info = mysqli_fetch_array($get_addresses_res)) {
			$address = stripslashes($add_info['address']);
			$city = stripslashes($add_info['city']);
			$state = stripslashes($add_info['state']);
			$zipcode = stripslashes($add_info['zipcode']);
			$tel_number = stripslashes($add_info['tel_number']);
			$email = stripslashes($add_info['email']);
			$preffered_contact = $add_info['preffered_contact_method'];

			$display_block .= "<li>$address $city $state $zipcode </li>
								<li>$tel_number </li>
								<li>$email </li>
								<li>Preffered Contact Method: $preffered_contact</li>";
		}

		$display_block .= "</ul>";
	}

	//free result
	mysqli_free_result($get_addresses_res);

	//get rewards
	$get_reward_sql = "SELECT points_earned, dollars_spent FROM points_earned
	                WHERE master_id = '".$safe_id."'";
	$get_reward_res = mysqli_query($mysqli, $get_reward_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_reward_res) > 0) {

		$display_block .= "<p><strong>Guest Rewards & Dollars Spent:</strong><br/>
		<ul>";

		while ($reward_info = mysqli_fetch_array($get_reward_res)) {
			$points_earned = stripslashes($reward_info['points_earned']);
			$dollars_spent = stripslashes($reward_info['dollars_spent']);

			$display_block .= "<li>Points: $points_earned, Dollars Spent: $$dollars_spent</li>";
		}

		$display_block .= "</ul>";
    }
    
    $get_reward_sql = "SELECT SUM(points_earned) AS total_points, SUM(dollars_spent) AS total_spent FROM points_earned
	                WHERE master_id = '".$safe_id."'";
	$get_reward_res = mysqli_query($mysqli, $get_reward_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_reward_res) > 0) {

		$display_block .= "<p><strong>Total Guest Rewards & Total Dollars Spent:</strong><br/>
		<ul>";

		while ($reward_info = mysqli_fetch_array($get_reward_res)) {
			$total_points_earned = stripslashes($reward_info['total_points']);
			$total_dollars_spent = stripslashes($reward_info['total_spent']);

			$display_block .= "<li>Points: $total_points_earned, Dollars Spent: $$total_dollars_spent</li>";
		}

		$display_block .= "</ul>";
	}

	//free result
	mysqli_free_result($get_reward_res);
// Print food review
	$display_block .= "<p><strong>Food Review: </strong><br/>
							<ul>
								<li>Item:  Quality/ Priciness</li>";
	//get food item1
	$get_review_sql = "SELECT food_item1, food_item1_quality, food_item1_priciness FROM guest_food_review_food1
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {
		
		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$food_item1 =  stripslashes($review_info['food_item1']);
			$food_item1_quality =  stripslashes($review_info['food_item1_quality']);
			$food_item1_priciness =  stripslashes($review_info['food_item1_priciness']);
			
			if($food_item1!=""){
				$display_block .="<li>$food_item1: $food_item1_quality/ $food_item1_priciness</li>";
			}
		}
	
	}

	$get_review_sql = "SELECT food_item2, food_item2_quality, food_item2_priciness FROM guest_food_review_food2
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {		

		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$food_item2 =  stripslashes($review_info['food_item2']);
			$food_item2_quality =  stripslashes($review_info['food_item2_quality']);
			$food_item2_priciness =  stripslashes($review_info['food_item2_priciness']);
			
			if($food_item2!=""){
				$display_block .="<li>$food_item2: $food_item2_quality/ $food_item2_priciness</li>";
			}
		}
	}

	$get_review_sql = "SELECT food_item3, food_item3_quality, food_item3_priciness FROM guest_food_review_food3
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {		

		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$food_item3 =  stripslashes($review_info['food_item3']);
			$food_item3_quality =  stripslashes($review_info['food_item3_quality']);
			$food_item3_priciness =  stripslashes($review_info['food_item3_priciness']);
			
			if($food_item3!=""){
				$display_block .="<li>$food_item3: $food_item3_quality/ $food_item3_priciness</li>";
			}
		}
	}

	$get_review_sql = "SELECT food_item4, food_item4_quality, food_item4_priciness FROM guest_food_review_food4
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {		

		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$food_item4 =  stripslashes($review_info['food_item4']);
			$food_item4_quality =  stripslashes($review_info['food_item4_quality']);
			$food_item4_priciness =  stripslashes($review_info['food_item4_priciness']);
			
			if($food_item4!=""){
				$display_block .="<li>$food_item4: $food_item4_quality/ $food_item4_priciness</li>";
			}
		}
	}

	$get_review_sql = "SELECT drink_item1, drink_item1_quality, drink_item1_priciness FROM guest_food_review_drink1
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {		

		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$drink_item1 =  stripslashes($review_info['drink_item1']);
			$drink_item1_quality =  stripslashes($review_info['drink_item1_quality']);
			$drink_item1_priciness =  stripslashes($review_info['drink_item1_priciness']);	
			
			if($drink_item1!=""){
				$display_block .="<li>$drink_item1: $drink_item1_quality/ $drink_item1_priciness</li>";
			}
		}
	}

	$get_review_sql = "SELECT drink_item2, drink_item2_quality, drink_item2_priciness FROM guest_food_review_drink2
	                WHERE master_id = '".$safe_id."'";
	$get_review_res = mysqli_query($mysqli, $get_review_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_review_res) > 0) {		

		while ($review_info = mysqli_fetch_array($get_review_res)) {
			$drink_item2 =  stripslashes($review_info['drink_item2']);
			$drink_item2_quality =  stripslashes($review_info['drink_item2_quality']);
			$drink_item2_priciness =  stripslashes($review_info['drink_item2_priciness']);
			
			if($drink_item2!=""){
				$display_block .="<li>$drink_item2: $drink_item2_quality/ $drink_item2_priciness</li>";
			}
		}
	}								
								
	$display_block .="</ul>";		

	//free result
	mysqli_free_result($get_review_res);

	//get all email
	$get_service_sql = "SELECT greeted_at_door, server_timeliness, server_friendliness,
				server_appearance, food_temp, food_delivery_time_mins, resteraunt_cleanliness,
				bathroom_cleanliness, additional_comments FROM guest_service_review
	                  WHERE master_id = '".$safe_id."'";
	$get_service_res = mysqli_query($mysqli, $get_service_sql) or die(mysqli_error($mysqli));

	 if (mysqli_num_rows($get_service_res) > 0) {

		$display_block .= "<p><strong>Service Review:</strong><br/>
		<ul>";

		while ($service_info = mysqli_fetch_array($get_service_res)) {
			$greeted_at_door = stripslashes($service_info['greeted_at_door']);
			$server_timeliness = stripslashes($service_info['server_timeliness']);
			$server_friendliness = stripslashes($service_info['server_friendliness']);
			$server_appearance = stripslashes($service_info['server_appearance']);
			$food_temp = stripslashes($service_info['food_temp']);
			$food_delivery_time_mins = stripslashes($service_info['food_delivery_time_mins']);
			$resteraunt_cleanliness = stripslashes($service_info['resteraunt_cleanliness']);
			$bathroom_cleanliness = stripslashes($service_info['bathroom_cleanliness']);
			$additional_comments = stripslashes($service_info['additional_comments']);

			if($additional_comments ==""){
				$display_block .= "<li>Greeted at Door: $greeted_at_door</li>
							<li>Server Timeliness: $server_timeliness</li>
							<li>Server Friendliness: $server_friendliness</li>
							<li>Server Appearance: $server_appearance</li>
							<li>Temperature of Food: $food_temp</li>
							<li>How Long Food Took After Ordering: $food_delivery_time_mins mins</li>
							<li>Server's Appearance: $resteraunt_cleanliness</li>
							<li>Bathroom Cleanliness: $bathroom_cleanliness</li>";
			}else{
			$display_block .= "<li>Greeted at Door: $greeted_at_door</li>
							<li>Server Timeliness: $server_timeliness</li>
							<li>Server Friendliness: $server_friendliness</li>
							<li>Server Appearance: $server_appearance</li>
							<li>Temperature of Food: $food_temp</li>
							<li>How Long Food Took After Ordering: $food_delivery_time_mins mins</li>
							<li>Server's Appearance: $resteraunt_cleanliness</li>
							<li>Bathroom Cleanliness: $bathroom_cleanliness</li>
							<li>Additional Comments: $additional_comments</li>";
			}
		}

		$display_block .= "</ul>";
	}

	//free result
	mysqli_free_result($get_service_res);


	$display_block .= "<br/>
    <footer><a href=\"maDeetersReward.php\">Add Rewards</a>
        ...<a href=\"maDeetersReview.php\">Add Food Review</a>
        ...<a href=\"maDeetersServiceReview.php\">Add Service Review</a><br/>
        ...<a href=\"".$_SERVER['PHP_SELF']."\">Select Another Guest</a>...<a href='maDeetersAddGuest.php'>Add A Guest</a>
        ...<a href=\"maDeetersDBMenu.html\">main menu</a></footer>";
}
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
<title>Ma Deeter's Select</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $display_block; ?>
</body>
</html>
						