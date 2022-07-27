<?
$session_id = session_id();

$user_ip = "";
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = $_SERVER['REMOTE_ADDR'];

if(filter_var($client, FILTER_VALIDATE_IP))
{
	$user_ip = $client;
}
elseif(filter_var($forward, FILTER_VALIDATE_IP))
{
	$user_ip = $forward;
}
else
{
	$user_ip = $remote;
}

$userid = 0;
$loggedin = 0;
$sessionid = 0;
$content = mysqli_query($conn,"
	SELECT Id, UserId FROM Session 
	WHERE 
		SessionId = '$session_id' AND 
		ClientIp = '$user_ip' AND 
		LastUsed > (NOW() - INTERVAL 30 MINUTE)
	");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$loggedin = 1;
	$userid = $row["UserId"];
	$sessionid = $row["Id"];
}

if ($loggedin == 1)
{
	$content = mysqli_query($conn,"
		SELECT UserName FROM User 
		WHERE Id = '$userid' 
		");
	while($content <> null && $row = mysqli_fetch_assoc($content))
	{
		$username = $row["UserName"];
	}
	
	$q1 = "UPDATE Session SET LastUsed = NOW() WHERE Id = '$sessionid'";
	mysqli_query($conn, $q1);
}
?>