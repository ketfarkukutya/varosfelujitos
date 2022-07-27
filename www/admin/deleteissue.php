<?
	session_start();
	include_once("../config.php");
	include_once("logger.php");
	include_once("userlogsend.php");
	
	$searchterms = urldecode($_GET["st"]);
	$issueid = $_GET['i'];
	
	$q1 = "DELETE FROM Issue WHERE Id = '$issueid' ";
	mysqli_query($conn, $q1);
	
?>
<script>
location.replace("<? print("$baselocation");?>admin/adminlist.php?<? print("$searchterms");?>");
</script>
	