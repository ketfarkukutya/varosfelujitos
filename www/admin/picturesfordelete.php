<style>
.thumb {
    display: inline-block;
    width: 200px;
    height: 200px;
    margin: 5px;
    border: 1px solid #362E38;
    background-position: center center;
    background-size: cover;
}
.thumbsmall {
    display: inline-block;
    width: 100px;
    height: 100px;
    margin: 3px;
    border: 1px solid #362E38;
    background-position: center center;
    background-size: cover;
}
</style>
<script>
function deletepicture (picture, issue)
	{
		if (confirm('Biztosan törölni akarod a képet?')) {
			location.replace("<? print("$baselocation");?>admin/deletepicture.php?p=" + picture + "&i=" + issue);
		}
	}
</script>
<?
$numpicture = 0;
$content = mysqli_query($conn,"
	SELECT * FROM Picture WHERE Issue = '$issueid'");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$numpicture++;
	$picturetitle = $row["Title"];
	$picturelink = $row["Link"];
	$pictureid = $row["Id"];
	?>
		<div class="col-md-3" style="text-align: center;">
			<a href="<? print("$baselocation"."$picturelink"); ?>" target="_blank">
				<div class="thumb" style="background-image: url('<? print("$baselocation"."$picturelink"); ?>');" title="<? print($picturetitle); ?>"></div>
			</a><br />
			<img src="<? print("$baselocation"); ?>img/delete_icon_s.png" style="width: 18px; cursor: pointer;" title="Törlés" alt="Törlés" onclick="deletepicture(<? print("$pictureid"); ?>, <? print("$issueid"); ?>);" />
		</div>
	<?
}
if ($numpicture == 0)
{
	?>
		<div class="col-md-12">
			Nem csatoltak képet a bejelentéshez.
		</div>
	<?
}
?>
