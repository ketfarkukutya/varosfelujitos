<?
	session_start();
	include_once("../config.php");
	include_once("logger.php");
	include_once("userlogsend.php");
	
	$searchterms = urldecode($_GET["st"]);
	$issueid = $_GET['i'];
	$pictureid = $_GET['p'];
	
	$q1 = "DELETE FROM Picture WHERE Id = '$pictureid' ";
	mysqli_query($conn, $q1);
	
?>
<script>
location.replace("<? print("$baselocation");?>admin/updateissue.php?i=<? print("$issueid");?>");
</script>
	