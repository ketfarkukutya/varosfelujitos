<?
$numpicture = 0;
$contentx = mysqli_query($conn,"
	SELECT * FROM Picture WHERE Issue = '$issueid' ORDER BY Type DESC LIMIT 1");
while($content <> null && $rowx = mysqli_fetch_assoc($contentx))
{
	$numpicture++;
	$picturetitle = $rowx["Title"];
	$picturelink = $rowx["Link"];
	?><br /><a href="<? print("$baselocation"."$picturelink"); ?>" target="_blank"><div class="thumbsmall" style="background-image: url(\'<? print("$baselocation"."$picturelink"); ?>\');" title="<? print($picturetitle); ?>"></div></a><?
}
?>
