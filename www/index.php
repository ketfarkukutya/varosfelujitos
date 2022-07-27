<html>
    <head>
<? 
	require_once("config.php");
	include_once("htmlhead.php");
?>
        <script>
            if ( window.self !== window.top ) {
                window.top.location.href=window.location.href;
            }
        </script>
		<script src="<? print("$baselocation"); ?>js/getmaps.js"></script>
		<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script>
			google.maps.event.addDomListener(window, 'load', initialize);
			
			function bookmark() {
					return "";
			}
			function bookUp(address, latitude, longitude) {
				return false;
			}
			function simulateClick(latitude, longitude) {
				var mev = {
					stop: null,
					latLng: new google.maps.LatLng(latitude, longitude)
				}
				google.maps.event.trigger(map, 'click', mev);
			}	
		</script>
		<? 
			include_once("issuetypes.php");
			include_once("issuestatuses.php"); 
			$pagetype = 0;
			$issueid = 0;
			if ($_GET['u'] == 'success')
			{
				$issueid = $_GET['i'];
				if ($issueid == 0)
					$pagetype = 4;
				else
					$pagetype = 1;
			}
			if ($_GET['u'] == 'issue')
			{
				$issueid = $_GET['i'];
				if ($issueid == 0)
					$pagetype = 4;
				else
					$pagetype = 1;
			}
			if ($_GET['u'] == 'upload')
			{
				$pagetype = 2;
			}
			if ($_GET['u'] == 'stat')
			{
				$pagetype = 3;
			}
			if ($_GET['u'] == 'map')
			{
				$pagetype = 4;
			}
			if ($_GET['u'] == 'list')
			{
				$pagetype = 5;
			}
			if ($_GET['u'] == 'home')
			{
				$pagetype = 0;
			}
		?>
    </head>
    <body style="width: 98%;">

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v3.0&appId=<? print("$fbappid"); ?>&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
		<? include_once("header.php"); ?>
		<? include_once("base.php"); ?>
		<? include_once("list.php"); ?>
		<? include_once("maplist.php"); ?>
		<? include_once("issue.php"); ?>
		<? include_once("statistics.php"); ?>
		<? include_once("applicate.php"); ?>

		<?
		if ($pagetype != 0)
		{
		?>
		<div class="row" style="text-align: center;">
			<img src="img/newbanner.png" style="padding: 10px; width: 95%; max-width: 900px;" />
		</div>
		<?
		}
		?>
		
		<script>
			function getActualPosition() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
					codeLatLng(1);
				} else { 
					alert("Böngészője nem támogatja a helyzetének lekérését.");
				}
			}
			
			function showPosition(position) {
				document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
			}

			$("#address").bind("keypress", {}, keypressInBox);
			
			function keypressInBox(e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if(event.target.tagName != 'TEXTAREA') {
				if (code == 13) {                       
					codeAddress();
				}
				}
			};

			$(document).ready(function() {
			  $("form").keypress(function(e) {
				if(event.target.tagName != 'TEXTAREA') {
					if (e.which == 13) {
					  return false;
					}
				}
			  });
				$('.selectall').focus(function() {
					$(this).select();
				});                        
			});
			
			function setBase()
			{
				document.getElementById("base").style.display = 'block';
				document.getElementById("applicate").style.display = 'none';
				document.getElementById("issue").style.display = 'none';
				document.getElementById("list").style.display = 'none';
				document.getElementById("maplist").style.display = 'none';
				document.getElementById("statistics").style.display = 'none';
			}
			
			function setIssue()
			{
				document.getElementById("base").style.display = 'none';
				document.getElementById("applicate").style.display = 'none';
				document.getElementById("issue").style.display = 'block';
				document.getElementById("list").style.display = 'none';
				document.getElementById("maplist").style.display = 'none';
				document.getElementById("statistics").style.display = 'none';
			}
			
			function setList()
			{
				document.getElementById("base").style.display = 'none';
				document.getElementById("applicate").style.display = 'none';
				document.getElementById("issue").style.display = 'none';
				document.getElementById("list").style.display = 'block';
				document.getElementById("maplist").style.display = 'none';
				document.getElementById("statistics").style.display = 'none';
			}
			
			function setMaplist()
			{
				document.getElementById("base").style.display = 'none';
				document.getElementById("applicate").style.display = 'none';
				document.getElementById("issue").style.display = 'none';
				document.getElementById("list").style.display = 'none';
				document.getElementById("maplist").style.display = 'block';
				document.getElementById("statistics").style.display = 'none';
			}
			
			function setStatistics()
			{
				document.getElementById("base").style.display = 'none';
				document.getElementById("applicate").style.display = 'none';
				document.getElementById("issue").style.display = 'none';
				document.getElementById("list").style.display = 'none';
				document.getElementById("maplist").style.display = 'none';
				document.getElementById("statistics").style.display = 'block';
			}
			
			function setApplicate()
			{
				document.getElementById("base").style.display = 'none';
				document.getElementById("applicate").style.display = 'block';
				document.getElementById("issue").style.display = 'none';
				document.getElementById("list").style.display = 'none';
				document.getElementById("maplist").style.display = 'none';
				document.getElementById("statistics").style.display = 'none';
			}
			
			<?
				switch ($pagetype)
				{
					case 0:
						print("setBase();");
						break;
					case 1:
						print("setIssue();");
						break;
					case 2:
						print("setApplicate();");
						break;
					case 3:
						print("setStatistics();");
						break;
					case 4:
						print("setMaplist();");
						break;
					case 5:
						print("setList();");
						break;
					default:
						print("setApplicate();");
						break;
				}
			?>
		</script>
		<script src="<? print("$baselocation"); ?>js/bootstrap.min.js"></script>
    </body>
</html>

