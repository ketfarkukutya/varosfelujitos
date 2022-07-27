<? 
	session_start();
	include_once("../config.php");
	include_once("logger.php");
	include_once("userlogsend.php");
?>
<html>
    <head>
<?
	include_once("../htmlhead.php");
	include_once("../header.php");
	include_once("../issuetypes.php");
	include_once("../issuestatuses.php");
	$searchterms = urlencode($_SERVER['QUERY_STRING']);
?>
    </head>
    <body>
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script>
		function startsetstatus (issue)
		{
			document.getElementById("statussetter" + issue).style.display = 'block';
			document.getElementById("startsetstatus" + issue).style.display = 'none';
		}
		
		function setactualstatusoption (issue, status)
		{
			document.getElementById("setstatus" + issue + "to" + status).style.display = 'none';
			
		}
		
		function setstatusto (issue, status)
		{
			location.replace("<? print("$baselocation");?>admin/setstatus.php?i=" + issue + "&s=" + status + "&st=<? print("$searchterms");?>");
		}
		
		function updateissue (issue)
		{
			location.replace("<? print("$baselocation");?>admin/updateissue.php?i=" + issue + "&st=<? print("$searchterms");?>");
		}
		
		function deleteissue (issue)
		{
			if (confirm('Biztosan törölni akarod a bejelentést?')) {
				location.replace("<? print("$baselocation");?>admin/deleteissue.php?i=" + issue + "&st=<? print("$searchterms");?>");
			}
		}
	</script>
	
	<div class="container" id="list" style="margin-top: 5px;">
		<div class="row">
			<h2 style="margin-left: 20px; margin-top: 5px;">Bejelentések listája</h2>
			<table class="table" style="width: 95%; margin: 0 auto;">
				<thead>
				  <tr>
					<th style="width: 15%;">Neve</th>
					<th style="width: 15%;">Bejelentő</th>
					<th style="width: 15%;">Státusza</th>
					<th style="width: 29%;">Helye</th>
					<th style="width: 15%;">Dátum</th>
					<th style="width: 3%;"></th>
					<th style="width: 3%;"></th>
				  </tr>
				</thead>
				<tbody>
			<?
				$content = mysqli_query($conn,"
					SELECT * FROM Issue
					ORDER BY Created DESC");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{
					$issueid = $row["Id"];
					$issuetitle = $row["Title"];
					$issuetypetext = $issuetypesshort[$row["Type"]];
					$issueaddress = $row["Address"];
					$issuestatus = $row["Status"];
					$created = $row["Created"];
					$userid = $row["ApplicantUser"];
					
					$ucontent = mysqli_query($conn,"
					SELECT * FROM User WHERE Id = '$userid'");
					while($ucontent <> null && $urow = mysqli_fetch_assoc($ucontent))
					{
						$useremail = $urow["UserEmail"];
					}
					
					?>
					<tr>
						<td>
							<a href="<? print("$baselocation"); ?>?u=issue&i=<? print("$issueid"); ?>"><? print("$issuetitle"); ?></a>
						</td>
						<td>
							<? print("$useremail"); ?>
						</td>
						<td>
							<? print("$issuestatuses[$issuestatus]"); ?>
							<span onclick="startsetstatus(<? print("$issueid"); ?>);" style="color: #428bca; cursor: pointer;" id="startsetstatus<? print("$issueid"); ?>">
								Módosít
							</span>
							<div id="statussetter<? print("$issueid"); ?>" style="display: none;">
								<?
									for ($i = 0; $i < count($issuestatuses); $i++)
									{
										?>
										<div id="setstatus<? print("$issueid"."to"."$i"); ?>" style="display: block; font-size: 14px; cursor: pointer; color: #428bca;" onclick="setstatusto(<? print("$issueid".", "."$i"); ?>);">
											<? print("$issuestatuses[$i]"); ?>
										</div>
										<?
									}
								?>
								<script>
									setactualstatusoption(<? print("$issueid".", "."$issuestatus"); ?>);
								</script>
							</div>
						</td>
						<td>
							<? print("$issueaddress"); ?>
						</td>
						<td>
							<? print("$created"); ?>
						</td>
						<td>
							<img src="<? print("$baselocation"); ?>img/update_icon_s.png" style="width: 18px; cursor: pointer;" title="Szerkesztés" alt="Szerkesztés" onclick="updateissue(<? print("$issueid"); ?>);" />
						</td>
						<td>
							<img src="<? print("$baselocation"); ?>img/delete_icon_s.png" style="width: 18px; cursor: pointer;" title="Törlés" alt="Törlés" onclick="deleteissue(<? print("$issueid"); ?>);" />
						</td>
					</tr>
					<?
				}
			?>
				</tbody>
			</table>
		</div>
	</div>

		<script src="<? print("$baselocation"); ?>js/bootstrap.min.js"></script>
    </body>
</html>

