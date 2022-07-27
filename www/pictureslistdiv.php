<?
$numpicture = 0;
$contentx = mysqli_query($conn,"
	SELECT * FROM Picture WHERE Issue = '$issueid' ORDER BY Type DESC LIMIT 1");
while($content <> null && $rowx = mysqli_fetch_assoc($contentx))
{
	$numpicture++;
	$picturetitle = $rowx["Title"];
	$picturelink = $rowx["Link"];
	
	$picturelinkss = str_replace("imageuploads","imageuploadsthumbss",$picturelink);
	$picturelinkss = str_replace(".png",".jpg",$picturelinkss);
	$picturelinkss = str_replace(".PNG",".jpg",$picturelinkss);
	$picturelinkss = str_replace(".jpeg",".jpg",$picturelinkss);
	$picturelinkss = str_replace(".JPEG",".jpg",$picturelinkss);
	$picturelinkss = str_replace(".JPG",".jpg",$picturelinkss);
	$picturelinkss = "http://sceurpien.com/fixmystreet/"."$picturelinkss";
	//if (file_exists($picturelinkss))
	//if (@file_get_contents($picturelinkss, 0, NULL, 0, 1))
		
	$d1 = new DateTime($rowx["Created"]);
	$d2 = new DateTime('2018-11-24 22:00:00');

	if ($d1 <= $d2)
	{
		?><div class="thumblistpicture" style="background-image: url('<? print("$picturelinkss"); ?>');" title="<? print($issuetitle); ?>"></div><?	
	}
	else
	{
		?><div class="thumblistpicture" style="background-image: url('<? 
			print("$baselocation"."$picturelink"); 
			?>');" title="<? print($issuetitle); ?>" alt="<? print($picturelinkss); ?>"></div><?
	}
	
}

if ($numpicture == 0)
{
?><div class="thumblistpicture" style="background-image: url('<? print("$baselocation"."img/default_pic.png"); ?>');" title="<? print($issuetitle); ?>"></div><?
}
?>
