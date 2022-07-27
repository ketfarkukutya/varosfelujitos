<div class="container" id="issue" style="margin-top: 5px;">
<?
$issueid = mysqli_real_escape_string($conn,$_GET['i']);
$isissuecheck = 0;
$content = mysqli_query($conn,"
	SELECT * FROM Issue WHERE Id = '$issueid' ORDER BY Created DESC");
while($content <> null && $row = mysqli_fetch_assoc($content))
{
	$isissuecheck = 1;
	$issuetitle = $row["Title"];
	$issuetype = $row["Type"];
	$issuedescription = $row["Description"];
	$issuesolution = $row["SolutionIdee"];
	$issueaddress = $row["Address"];
	$issuestatus = $row["Status"];
	$issuelatitude = $row["Latitude"];
	$issuelongitude = $row["Longitude"];
	$issuecost = $row["Cost"];
	$issuefixed = $row["Fixed"];
	$issuefbevent = $row["FacebookEvent"];
	$issuefbdate = $row["FacebookEventDate"];
	$issuesolutiontext = $row["SolutionText"];
	
	$issuetypex = $issuetype;
	
	if ($issuetype > 3)
		$issuetypex--;
	
	$iconurl = $baselocation."img/markers/marker_".$issuestatuscolor[$issuestatus]."_small/marker_".$issuetypex.".png";
}

if ($isissuecheck == 1)
{
?>


	<div class="row">
		
		<h2 style="margin-left: 20px; margin-top: 5px;">
			<img style="display: inline; height: 30px;" src="<? print ($iconurl); ?>" title="Típus: <? print("$issuetypesshort[$issuetype]"); ?>" alt="Típus: <? print("$issuetypesshort[$issuetype]"); ?>" />
			Bejelentés: <? print("$issuetitle"); ?>
		</h2>
		<div class="col-md-12">	
			<div class="row">

		<? 
		if (trim($issuesolutiontext) != '') 
		{ 
		?>
				<div class="col-md-12">
					<b>Történet:</b><br />
					<? print("$issuesolutiontext"); ?>
				</div>
		<?
		}
		?>
				<div class="col-md-12">
					<b>Hiba leírása:</b><br />
					<? print("$issuedescription"); ?>
				</div>
				
				<div class="col-md-12">
					<b>Megoldási javaslat:</b><br />
					<? print("$issuesolution"); ?>
				</div>
				
				<?
				if ($issuecost <> '')
				{
				?>
			
				<div class="col-md-12">
					<b>Megvalósítási költség:</b>
					<? print(" $issuecost"); ?>
				</div>
				
				<?
				}
				?>
				
			</div>
			<div class="row">
				<div class="col-md-12">
					<b>Helye:</b><br />
					<b>Cím:<b/><? print(" $issueaddress"); ?><br />
					<b>Hosszúsági / szélességi fok:<b/><? print(" $issuelatitude / $issuelongitude"); ?><br />
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<h4 style="padding-top: 10px;">Képek</h4>
				</div>
				<?
					include("pictures.php");
				?>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<h4 style="padding-top: 10px;">Megoldás / javítás</h4>
				</div>
				
				<?
				$isany = 0;
				if ($issuefixed <> '' && $issuefixed <> NULL)
				{
					$isany = 1;
				?>
				<div class="col-md-12">
					<b>Javítás dátuma:</b><br />
					<? print("$issuefixed"); ?>
				</div>
				<?
				}
				?>
				<?
				if ($issuefbdate <> '' && $issuefbdate <> NULL)
				{
					$isany = 1;
				?>
				<div class="col-md-6">
					
				</div>
				<div class="col-md-12">
					<b><a href="<? print("$issuefbevent"); ?>" target="_blank">Facebook esemény</a></b><br />
					<? print("$issuefbdate"); ?>
				</div>
				<?
				}
				
				if ($isany == 0)
				{
					?>
					<div class="col-md-12">
						Sajnos még nincs csatolt facebook esemény, vagy tervezett javítási dátum az eseményhez.
					</div>
					<?
				}
				?>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<h4 style="padding-top: 10px;">Végeredmény képek</h4>
				</div>
				<?
					include("picturesresolution.php");
				?>
			</div>
			<div class="row">
				<div class="col-md-12" style="text-align: center;">
					<div class="fb-comments" data-href="<? print("$baselocation"); ?>?u=issue&amp;i=<? print("$issueid"); ?>" data-width="100%" data-numposts="5"></div>
				</div>
			</div>
		</div>
	</div>

<?


}
?>
</div>

