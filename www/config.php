<?
$googleapikey = "AIzaSyCamT5zj1Oe6j42B80K3JnFphF5BsNvhos";
$googleapikeybase = "AIzaSyAiodCnWoLM-dtvozc_1a1kEOcF072UbBA";
$googleapiapplicationname = "FixMyStreetMKKP";
$baselocation = "https://varosfelujitos.mkkp.party/";
$baselocationsbs = "https://varosfelujitos.mkkp.party";
$fbappid = "931629677003241";

$servername = "db-mysql";
$dbname = "varosfelujitos";
$username = "varosfelujitos";
$password = "rFgnt6GuRnLvsjnM";

#$servername = "localhost";
#$dbname = "fixmystreet";
#$username = "fixmystreet";
#$password = "fixmystreet";

// ------------------------------------------------------------------------------
// Ez alatt ne nyúlj hozzá !!!!!!!!!!!!!!!!!
// ------------------------------------------------------------------------------

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

	if (mysqli_query($GLOBALS["conn"], $query)) {
		echo "$message";
	} else {
		echo "Error: " . mysqli_error($GLOBALS["conn"]);
	}
}

$baselink = $baselocation;
$baselinksbs = $baselocationsbs;

?>
