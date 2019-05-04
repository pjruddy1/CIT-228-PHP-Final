<?php
include 'maDeetersConnect.php';
doDB();
//check for required fields from the form
if (($_POST['username']=="") || ($_POST['password']=="")) {
    header("Location: userlogin.html");
    exit;
}
$display_block="";
//connect to server and select database
//$mysqli = mysqli_connect("localhost", "root", "", "guest_reward_and_review") or die(mysql_error());
//$mysqli = mysqli_connect("localhost", "https://www.lisabalbach.com", "", "Ruddyp") or die(mysql_error());


//use mysqli_real_escape_string to clean the input
$safe_username = mysqli_real_escape_string($mysqli, $_POST['username']);
$safe_password = mysqli_real_escape_string($mysqli, $_POST['password']);

//create and issue the query
$sql = "SELECT first_name, last_name FROM auth_users WHERE username = '".$safe_username."' AND password = '".$safe_password."'";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

//get the number of rows in the result set; should be 1 if a match
if (mysqli_num_rows($result) == 1) {
	header("Location: maDeetersDBMenu.html");
	exit;
} else {
    //redirect back to login form if not authorized
    $display_block .= "<footer><p>Please contact our IT Dept. (Invalid Username and Password)</p><br/>";
    $display_block .= "<p><a href='userlogin.html'> Return to login</a></p></footer>";
}

//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php echo $display_block; ?>

</body>
</html>
