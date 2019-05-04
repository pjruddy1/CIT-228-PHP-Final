<?php
$mysqli = mysqli_connect("localhost", "lisabalbach_ruddyp", "CIT19020003", "lisabalbach_Ruddy");
if(mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$get_guest_info = "SELECT * FROM guest_info";
$get_guest_info_res = mysqli_query($mysqli, $get_guest_info) or die(mysqli_error($mysqli));

$xml = "<maDeeters_guests>";
while($r = mysqli_fetch_array($get_guest_info_res)){
   print_r ($r);
    $xml .= "<guest>";
    $xml .="<master_id>".$r['master_id']."</master_id>";
    $xml .="<first_name>".$r['first_name']."</first_name>";
    $xml .="<last_name>".$r['last_name']."</last_name>";
    $xml .="<date_added>".$r['date_added']."</date_added>";
    $xml .="<date_modified>".$r['date_modified']."</date_modified>";
    $xml .="<address>".$r['address']."</address>";
    $xml .="<city>".$r['city']."</city>";
    $xml .="<state>".$r['state']."</state>";
    $xml .="<zipcode>".$r['zipcode']."</zipcode>";
    $xml .="<email>".$r['email']."</email>";
    $xml .="<tel_number>".$r['tel_number']."</tel_number>";
    $xml .="<preffered_method>".$r['preffered_contact_method']."</preffered_method>";
    $xml .= "</guest>";
}
$xml .="</maDeeters_guests>";
$sxe = new SimpleXMLElement($xml);
$sxe->asXML("Guests.xml");
echo "<h1>Guests.xml has been created</h2>";
echo "<p><a href='guest_list_read1.php'>[View Contact List]</a>";

?>
<!DOCTYPE html>
<html>
<head>
<title>Add Guest XML</title>
<link href="css/maDeeters.css" type="text/css" rel="stylesheet" />
</head>
<body>

</body>
</html>