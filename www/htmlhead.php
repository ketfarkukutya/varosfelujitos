<?
$issueid = $_GET['i'];
$isissuecheck = 0;
$content = mysqli_query($conn,"
	SELECT * FROM Issue WHERE Id = '$issueid' ORDER BY Created DESC");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$isissuecheck = 1;
	$issuetitle = $row["Title"];
	$issuetype = $row["Type"];
	$issuedescription = $row["Description"];
	$issuesolution = $row["SolutionIdee"];
	$issueaddress = $row["Address"];
	$issuestatus = $row["Status"];
	$issuelatitude = $row["Latitude"];
	$issuelongitude = $row["Longitude"];
	$assigneduser = $row["AssignedUser"];
	$applicantuser = $row["ApplicantUser"];
	$issuesolutiontext = $row["SolutionText"];
	
	$fbdescription = $issuedescription;
	if (trim($issuesolutiontext) != '') 
	{ 
		$fbdescription = $issuesolutiontext;
	}
}
$numpicture = 0;
$content = mysqli_query($conn,"
	SELECT * FROM Picture WHERE Issue = '$issueid' ORDER BY Type DESC LIMIT 1");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$numpicture = 1;
	$picturelink = $row["Link"];
}

?>
		<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
        <META http-equiv="Content-type" content="text/html; charset=iso-8859-2">
		<META charset="iso-8859-2">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <?
			if ($isissuecheck == 0)
			{
		?>
			<title>Rendkívüli Ügyek Minisztériuma</title>
			<meta name="og:title" content="Rendkívüli Ügyek Minisztériuma" />
			<meta name="description" content="Jelentsd be, milyen problémákat látsz a városban. Talán mi megoldjuk." />
		<?
			}
			if ($isissuecheck == 1)
			{
		?>
			<title><? print("Bejelentés: $issuetitle"); ?></title>
			<meta name="og:title" content="<? print("Bejelentés: $issuetitle"); ?>" />
			<meta name="description" content="<? print("$fbdescription"); ?>" />
			<meta name="og:description" content="<? print("$fbdescription"); ?>" />
			<meta name="og:type" content="article" />
			<meta name="og:url" content="<? print("$baselocation?u=issue&i=$issueid"); ?>" />
		<?
			}
			if ($numpicture == 0)
			{
		?>
			<meta name="og:image" content="<? print("$baselocation"); ?>img/fbthumb.jpg" />
		<?
			}
			if ($numpicture == 1)
			{
		?>
			<meta name="og:image" content="<? print("$baselocation"."$picturelink"); ?>" />
		<?
			}
		?>
		<meta property="og:locale" content="hu_HU" />
		<meta property="og:site_name" content="Rendkívüli Ügyek Minisztériuma" />
		<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<? print("$googleapikeybase"); ?>&language=en&libraries=places"></script>
        <link rel="stylesheet" href="<? print("$baselocation"); ?>css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<? print("$baselocation"); ?>css/gps-coordinates.css" type="text/css" />
		<link rel="stylesheet" href="<? print("$baselocation"); ?>css/fixmystreet.css" type="text/css" />
        <link rel="icon" type="image/x-icon" href="<? print("$baselocation"); ?>img/favicon-96x96.png" />
        <link rel="apple-touch-icon" href="<? print("$baselocation"); ?>img/apple-icon-144x144.png">
		<script>var loaderUrl = "<? print("$baselocation"); ?>img/loader.gif";</script>
        