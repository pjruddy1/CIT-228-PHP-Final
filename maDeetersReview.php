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
	<input type="text" name="master_id" size="30" maxlength="6" required="required"/>
	</fieldset>

	<fieldset>
	<legend>Food Item 1/ Quality of Food(1-10)(poor-great)/ Price Fairness(1-10)(poor-great):</legend><br/>
	<input type="text" name="food_item1" size="30" maxlength="50" />
	<input type="number" name="food_item1_quality" size="5" min="1" max="10"/>
	<input type="number" name="food_item1_priciness" size="5" min="1" max="10"/>
	</fieldset>

	<fieldset>
	<legend>Food Item 2/ Quality of Food(1-10)/ Price Fairness(1-10):</legend><br/>
	<input type="text" name="food_item2" size="30" maxlength="50" />
	<input type="number" name="food_item2_quality" size="5" min="1" max="10"/>
	<input type="number" name="food_item2_priciness" size="5" min="1" max="10"/>
	</fieldset>

	<fieldset>
	<legend>Food Item 3/ Quality of Food(1-10)/ Price Fairness(1-10):</legend><br/>
	<input type="text" name="food_item3" size="30" maxlength="50" />
	<input type="number" name="food_item3_quality" size="5" min="1" max="10"/>
	<input type="number" name="food_item3_priciness" size="5" min="1" max="10"/>
	</fieldset>

	<fieldset>
	<legend>Food Item 4/ Quality of Food(1-10)/ Price Fairness(1-10):</legend><br/>
	<input type="text" name="food_item4" size="30" maxlength="50" />
	<input type="number" name="food_item4_quality" size="5" min="1" max="10"/>
	<input type="number" name="food_item4_priciness" size="5" min="1" max="10"/>
	</fieldset>

	<fieldset>
	<legend>Drink Item 1/ Quality of Drink(1-10)/ Price Fairness(1-10):</legend><br/>
	<input type="text" name="drink_item1" size="30" maxlength="50" />
	<input type="number" name="drink_item1_quality" size="5" min="1" max="10"/>
	<input type="number" name="drink_item1_priciness" size="5" min="1" max="10"/>
	</fieldset>

	<fieldset>
	<legend>Drink Item 2/ Quality of Drink(1-10)/ Price Fairness(1-10):</legend><br/>
	<input type="text" name="drink_item2" size="30" maxlength="50" />
	<input type="number" name="drink_item2_quality" size="5" min="1" max="10"/>
	<input type="number" name="drink_item2_priciness" size="5" min="1" max="10"/>
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
	$safe_food_item1 = mysqli_real_escape_string($mysqli,$_POST['food_item1']);
	$safe_food_item1_quality = mysqli_real_escape_string($mysqli,$_POST['food_item1_quality']);
	$safe_food_item1_priciness = mysqli_real_escape_string($mysqli,$_POST['food_item1_priciness']);
	$safe_food_item2 = mysqli_real_escape_string($mysqli,$_POST['food_item2']);
	$safe_food_item2_quality = mysqli_real_escape_string($mysqli,$_POST['food_item2_quality']);
	$safe_food_item2_priciness = mysqli_real_escape_string($mysqli,$_POST['food_item2_priciness']);
	$safe_food_item3 = mysqli_real_escape_string($mysqli, $_POST['food_item3']);
	$safe_food_item3_quality = mysqli_real_escape_string($mysqli,$_POST['food_item3_quality']);
	$safe_food_item3_priciness = mysqli_real_escape_string($mysqli,$_POST['food_item3_priciness']);
	$safe_food_item4 = mysqli_real_escape_string($mysqli,$_POST['food_item4']);
	$safe_food_item4_quality = mysqli_real_escape_string($mysqli,$_POST['food_item4_quality']);
	$safe_food_item4_priciness = mysqli_real_escape_string($mysqli,$_POST['food_item4_priciness']);
	$safe_drink_item1 = mysqli_real_escape_string($mysqli,$_POST['drink_item1']);
	$safe_drink_item1_quality = mysqli_real_escape_string($mysqli,$_POST['drink_item1_quality']);
	$safe_drink_item1_priciness = mysqli_real_escape_string($mysqli,$_POST['drink_item1_priciness']);
	$safe_drink_item2 = mysqli_real_escape_string($mysqli,$_POST['drink_item2']);
	$safe_drink_item2_quality = mysqli_real_escape_string($mysqli,$_POST['drink_item2_quality']);
	$safe_drink_item2_priciness = mysqli_real_escape_string($mysqli,$_POST['drink_item2_priciness']);

	if(($_POST['food_item1'])||($_POST['food_item2'])||($_POST['food_item3'])||($_POST['food_item4'])||($_POST['drink_item1'])||($_POST['drink_item2'])){
	
	if (($_POST['food_item1'])&&($_POST['food_item1_quality'])&&($_POST['food_item1_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_food1 (master_id, date_added, food_item1, food_item1_quality, food_item1_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_food_item1."', '".$safe_food_item1_quality."',
							 '".$safe_food_item1_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}

	if(($_POST['food_item2'])&&($_POST['food_item2_quality'])&&($_POST['food_item2_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_food2 (master_id, date_added, food_item2, food_item2_quality, food_item2_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_food_item2."', '".$safe_food_item2_quality."',
							 '".$safe_food_item2_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}

	if (($_POST['food_item3'])&&($_POST['food_item3_quality'])&&($_POST['food_item3_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_food3 (master_id, date_added, food_item3, food_item3_quality, food_item3_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_food_item3."', '".$safe_food_item3_quality."',
							 '".$safe_food_item3_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}

	if (($_POST['food_item4'])&&($_POST['food_item4_quality'])&&($_POST['food_item4_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_food4 (master_id, date_added, food_item4, food_item4_quality, food_item4_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_food_item4."', '".$safe_food_item4_quality."',
							 '".$safe_food_item4_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}

	if (($_POST['drink_item1'])&&($_POST['drink_item1_quality'])&&($_POST['drink_item1_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_drink1 (master_id, date_added, drink_item1, drink_item1_quality, drink_item1_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_drink_item1."', '".$safe_drink_item1_quality."',
							 '".$safe_drink_item1_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}

	if (($_POST['drink_item2'])&&($_POST['drink_item2_quality'])&&($_POST['drink_item2_priciness'])) {
		//something relevant, so add to address table
		$add_review_sql = "INSERT INTO guest_food_review_drink2 (master_id, date_added, drink_item2, drink_item2_quality, drink_item2_priciness)  VALUES 
						('".$master_id."', now(), '".$safe_drink_item2."', '".$safe_drink_item2_quality."',
							 '".$safe_drink_item2_priciness."')";
		$add_review_res = mysqli_query($mysqli, $add_review_sql) or die(mysqli_error($mysqli));
	}
}else{
	$display_block .="<h1><strong>There was an error adding your data.  You missed a required field for the reviewed item(s).</strong></h1>";
}

	mysqli_close($mysqli);
	$display_block="<footer>Your entry has been added.  Would you like to:<br/>
	<a href=\"maDeetersReward.php\">Add Rewards</a>
	...<a href=\"".$_SERVER['PHP_SELF']."\">Add Another Food Review</a>
	...<a href=\"maDeetersServiceReview.php\">Add Service Review</a><br/>
	...<a href=\"maDeetersSelect2.php\">select A Guest</a>...<a href='maDeetersAddGuest.html'>Add A Guest</a>
	...<a href='maDeetersDBMenu.html'>main menu</a></footer>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Guest Review</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h1>Add Guest Review</h1>
<?php echo $display_block; ?>
</body>
</html>