<div class="container" id="maplist" style="margin-top: 5px; display: none;">
<?
if ($pagetype == 4)
{
?>
	<script>
	var activeInfoWindow;    
	</script>
	<div class="row" style="text-align: center;">
		<h2 style="margin-left: 20px; margin-top: 5px;">Bejelentések térképe</h2>
		
		<div id="mapl" style="height: 600px; width: 90%; margin: 0 auto;"></div>
		<script>

		  function initMap() {
			var myLatLng = {lat: 47.49780002574056, lng: 19.04032051563263};

			var map = new google.maps.Map(document.getElementById('mapl'), {
				zoom: 13,
				center: myLatLng,
			});

			var features = [
			<?
				$content = mysqli_query($conn,"
					SELECT Id, Title, Type, Latitude, Longitude, Status FROM Issue ORDER BY Created DESC");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{
					$issueid = $row["Id"];
					$issuetitle = $row["Title"];
					$issuetype = $row["Type"];
					$issuetypetext = $issuetypesshort[$row["Type"]];
					$issuelatitude = $row["Latitude"];
					$issuelongitude = $row["Longitude"];
					$issuestatus = $row["Status"];
					
					if ($issuetype > 3)
						$issuetype--;
					
					$iconurl = $baselocation."img/markers/marker_".$issuestatuscolor[$issuestatus]."_small/marker_".$issuetype.".png";
					
					print("
						{
							position: new google.maps.LatLng($issuelatitude, $issuelongitude),
							icon: '$iconurl',
							title: '$issuetitle',
							content: '<div id=\"info_window\"><a href=\"$baselink?u=issue&i=$issueid\"><h6>$issuetitle</h6></a>$issuetypetext, $issuestatuses[$issuestatus]");
					include("picturesmall.php");
					print("</div>'},");
				}
			?>
			];

			// Create markers.
			features.forEach(function(feature) {
				var infowindow = new google.maps.InfoWindow({
					content: feature.content
				});
				var marker = new google.maps.Marker({
					position: feature.position,
					icon: feature.icon,
					map: map,
					title: feature.title
				});
				marker.addListener('click', function() {
					if (activeInfoWindow) { activeInfoWindow.close();}
					infowindow.open(map, marker);
					activeInfoWindow = infowindow;
				});
			});
		  }
		  initMap();
		</script>
		<img src="<? print($baselocation."img/jelmagyarazat.png");?>" style="width: 90%;" />
	</div>
<?
}
?>
</div>
		