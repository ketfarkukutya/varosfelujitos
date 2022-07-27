<?
$numpicture = 0;
$content = mysqli_query($conn,"
	SELECT * FROM Picture WHERE Issue = '$issueid' AND Type = 0");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$numpicture++;
	$picturetitle = $row["Title"];
	$picturelink = $row["Link"];
	?>
		<div class="col-md-3">
			<a href="<? print("$baselocation"."$picturelink"); ?>" target="_blank">
				<div class="thumb" style="background-image: url('<? print("$baselocation"."$picturelink"); ?>');" title="<? print($picturetitle); ?>"></div>
			</a>
		</div>
	<?
}
if ($numpicture == 0)
{
	?>
		<div class="col-md-12">
			Sajnos nem csatoltak képet a bejelentéshez.
		</div>
	<?
}
?>
