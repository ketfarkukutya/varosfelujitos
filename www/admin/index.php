<? 
	session_start();
	include_once("../config.php");
	include_once("logger.php");
?>
<html>
    <head>
<?
	include_once("../htmlhead.php");
	include_once("../header.php");
	include_once("../issuetypes.php");
	include_once("../issuestatuses.php");


if ($loggedin == 1)
{
?>
<script>
location.replace("<? print("$baselocation");?>admin/adminlist.php");
</script>
<?
}

if (isset($_POST['login']))
{
	$li_username = mysqli_real_escape_string($conn,$_POST['username']);
	$li_password = mysqli_real_escape_string($conn,$_POST['password']);
	
	$li_userid = 0;
	$li_loggedin = 0;
	
	$content = mysqli_query($conn,"
		SELECT Id FROM User 
		WHERE LOWER(UserName) = '$li_username'		
		");
	while($content <> null && $row = mysqli_fetch_assoc($content))
	{
		$li_userid = $row['Id'];
	}
	
	
	if ($li_userid <> 0)
	{
		$content = mysqli_query($conn,"
			SELECT 1 FROM Login 
			WHERE 	UserId = '$li_userid'		
				AND	Password = '$li_password'		
			");
		while($content <> null && $row = mysqli_fetch_assoc($content))
		{
			$li_loggedin = 1;
		}
	}
	
	if ($li_loggedin == 1)
	{
		
		$q1 = "INSERT INTO Session 
			(SessionId, ClientIp, LastUsed, UserId)
			VALUES
			('$session_id', '$user_ip', now(), '$li_userid')";
		mysqli_query($conn, $q1);
		
		?>
		<script>
		location.replace("<? print("$baselocation");?>admin/adminlist.php");
		</script>
		<?
	}
}
?>

    </head>
    <body>

<div class="container" id="applicate" style="margin-top: 5px;">
	<div class="row">
		<h2 style="margin-left: 20px; margin-top: 5px;">Bejelentkezés az admin rendszerbe</h2>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" role="form" method="post">

				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtitle">Név</label>
					<div class="col-md-9">
						<input id="username" class="form-control" type="textbox" name="username" placeholder="Felhasználónév" />
					</div>
				</div>			
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtitle">Jelszó</label>
					<div class="col-md-9">
						<input id="password" class="form-control" type="password" name="password" placeholder="Jelszó" />
					</div>
				</div>	
				
				<div class="form-group">
					<label for="submit" class="col-md-3 control-label"></label>
					<div class="col-md-9" style="text-align: right;">
						<input type="submit" id="login" name="login" class="btn btn-success" value="Belépés" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
		
    </body>
</html>