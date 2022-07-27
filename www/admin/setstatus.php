<?
	session_start();
	include_once("../config.php");
	include_once("logger.php");
	include_once("userlogsend.php");
	
	$searchterms = urldecode($_GET["st"]);
	$issueid = $_GET['i'];
	$status = $_GET['s'];
	
	$q1 = "UPDATE Issue SET Status = '$status' WHERE Id = '$issueid'";
	mysqli_query($conn, $q1);
	
?>
<script>
location.replace("<? print("$baselocation");?>admin/adminlist.php?<? print("$searchterms");?>");
</script>
	