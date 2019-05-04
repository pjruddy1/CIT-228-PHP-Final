<?php 
include 'maDeetersConnect.php';
doDB();
//$query="SELECT * FROM products LIMIT 20"; 
$query="SELECT * FROM guest_info"; 
$result=$mysqli->query($query)
	or die ($mysqli->error);

//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();

while($row=$result->fetch_assoc()) //mysql_fetch_array($sql)
{ 
$first_name=$row['first_name']; 
$last_name=$row['last_name']; 
$address=$row['address']; 
$city=$row['city']; 
$state=$row['state']; 
$zipcode=$row['zipcode']; 
$email=$row['email']; 
$tel_number=$row['tel_number']; 
$preffered_contact_method=$row['preffered_contact_method'];

//each item from the rows go in their respective vars and into the posts array
$posts[] = array('first_name'=> $first_name, 'last_name'=> $last_name, 'address'=>$address, 'city'=>$city,  'state'=>$state, 'zipcode'=>$zipcode,
		'email'=> $email, 'tel_number'=> $tel_number, 'preffered_contact_method'=> $preffered_contact_method); 
} 

//the posts array goes into the response
$response['Guests'] = $posts;

//creates the file
$fp = fopen('maDeetersGuests.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

$display_block="<p>Ma Deeter's Guests have been added to the Json file</p>";
$display_block.="<p><a href='maDeetersviewjsondata.php'>View Guest's Info</a></p>";
$display_block.="<p><a href='maDeetersDBMenu.html'>Main Menu</a></p>";
?> 
<!DOCTYPE html>
<html>
<head>
<title>Create Json File</title>    
</head>    
<body>
<?php echo $display_block ?>    
</body>
</html>