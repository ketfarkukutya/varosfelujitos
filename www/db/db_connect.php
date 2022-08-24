<?php

$servername = "db-mysql";
$dbname = "varosfelujitos";
$username = "varosfelujitos";
$password = "rFgnt6GuRnLvsjnM";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//mysql_select_db($dbname, $conn);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Function to Query DB
function DBQuery ($query, $message = "")
{
	return mysqli_query($GLOBALS["conn"], $query);
}

function DbQueryToJson ($query)
{
	$sth = DBQuery($query);
	$rows = array();
	while($r = mysqli_fetch_assoc($sth)) {
		$rows[] = $r;
	}
	return json_encode($rows);
}

?>