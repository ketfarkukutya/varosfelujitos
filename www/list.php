<?
$listtype = 'simple';
$listtype = $_GET['l'];

$searchstring = '1 = 1 ';

$searchfiltername = "";
$searchfiltertype = "";
$searchfilterstatus = "";

if (isset($_POST['search']))
{
	$searchfiltername = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['problemtitle']));
	$searchfiltertype = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['problemtype']));
	$searchfilterstatus = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['problemstatus']));
	if (strlen($searchfiltername) <> 0)
		$searchstring .= "AND Title LIKE '%$searchfiltername%' ";
	if (strlen($searchfiltertype) <> 0)
		$searchstring .= "AND Type = '$searchfiltertype' ";
	if (strlen($searchfilterstatus) <> 0)
		$searchstring .= "AND Status = '$searchfilterstatus' ";
}

// MKKP Discord Kockabarlang - Addon
// 4. hiba -> ,, - bejelentések nézetnél elég ha 50 látszik egyszerre. ''
//
// 		[+] csak 50 Issue jelenjen meg (mert nehézkes a képek betöltése)
// 		[+] előző oldal gomb
// 		[+] következő oldal gomb
$MAXISSUE = 50;
$pagenumber = 0;
$pagenumber_curr = 0;
$pagenumber_max = 0;
$pagenumber_max_item = 0;

$q_pagemax = "SELECT COUNT(Id) AS \"n\" FROM `Issue`;";
$result_pagemax = mysqli_query($conn, $q_pagemax);
while ( $r = mysqli_fetch_assoc($result_pagemax)) {
	$pagenumber_max_item = $r["n"];
	$pagenumber_max = ceil($r["n"]/$MAXISSUE);

}
if ( isset($_GET["n"]) && -1<intval($_GET["n"]) && intval($_GET["n"])<$pagenumber_max ) {
	$pagenumber_curr = intval($_GET["n"]);
	$pagenumber = ($pagenumber_curr * $MAXISSUE );
} else if ( isset($_GET["n"]) && -1 < intval($_GET["n"]) && intval($_GET["n"]) >= $pagenumber_max ) {
	$pagenumber_curr = ($pagenumber_max-1);
	$pagenumber = ( ($pagenumber_max-1) * $MAXISSUE );
}
$pagenumber_next = $baselink . "?u=list&n=" . ($pagenumber_curr+1);
$pagenumber_prew = $baselink . "?u=list&n=" . ($pagenumber_curr-1);
// [/MKKP Addon]
?>

<style>
.thumblistdiv {
    display: inline-block;
    width: 220px;
	height: 310px;
    margin: 3px;
	border-radius: 3px;
    background-color: #FFFFF0;
	text-align: center;
	cursor: pointer;
	box-shadow: 5px 5px;
}

.thumblistdivresolved {
    display: inline-block;
    width: 220px;
	height: 310px;
    margin: 3px;
	border-radius: 3px;
    background-color: #FFFFF0;
	text-align: center;
	cursor: pointer;
	box-shadow: 5px 5px #416837;
}

.thumblistpicture {
    display: inline-block;
    width: 220px;
    height: 220px;
    background-position: center center;
    background-size: cover;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px;
}

.thumblistcontent {
    display: inline-block;
    width: 100%;
    margin: 3px;
    text-align: left;
	white-space: nowrap;
	overflow-x: hidden;
	overflow-y: hidden;
	line-height: 120%;
}
.navisor {
	background-color: #2B443C;
	width: conte;
	height: min-content;
}
</style>
<script>
	function openissue (issue)
		{
			location.replace("<? print("$baselocation");?>?u=issue&i=" + issue);
		}
</script>
<div class="container" id="list" style="margin-top: 5px; display: none;">
<?
if ($pagetype == 5)
{
?>
	<div class="row">
		<h2 style="margin-left: 20px; margin-top: 5px;">Bejelentések listája</h2>
		<div class="row" style="margin-left: 40px;">
			<form class="form-horizontal" role="form" method="post">
				<div class="form-group">
					<div class="col-md-3">
						<input id="problemtitle" class="form-control" type="textbox" name="problemtitle" placeholder="Szöveges kereső" value="<? print($searchfiltername); ?>">
					</div>
					<div class="col-md-3">
						<select id="problemtype" class="form-control" name="problemtype">
							<option value="" style="color: #4B645C; font-style: italic;" <? if ($searchfiltertype == "") { print("selected"); } ?>>Minden típus</option>
							<?
								for ($i = 0; $i < count($issuetypeslong); $i++)
								{
									if ($searchfiltertype == $i && $searchfiltertype != "")
										print ("<option value=\"$i\" selected>$issuetypeslong[$i]</option>");
									else
										print ("<option value=\"$i\">$issuetypeslong[$i]</option>");
								}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<select id="problemstatus" class="form-control" name="problemstatus">
							<option value="" style="color: #2B443C; font-style: italic;" <? if ($searchfilterstatus == "") { print("selected"); } ?>>Minden státusz</option>
							<?
								for ($i = 0; $i < count($issuestatuses); $i++)
								{
									if ($searchfilterstatus == $i&& $searchfilterstatus != "")
										print ("<option value=\"$i\" selected>$issuestatuses[$i]</option>");
									else
										print ("<option value=\"$i\">$issuestatuses[$i]</option>");
								}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<input type="submit" id="search" name="search" class="btn btn-primary" value="Keresés" />
					</div>					
				</div>
				<div class="form-group">
					<input type="button" class="btn btn-warning" value="Előző oldal" onclick="<? echo "window.location.replace('$pagenumber_prew')"; ?>" />
					<?
						print($pagenumber_curr+1);
						print(" / ");
						print($pagenumber_max);
					?>
					<input type="button" class="btn btn-warning" value="Következő oldal" onclick="<? echo "window.location.replace('$pagenumber_next')"; ?>" />
				</div>
			</form>
		</div>
		<?
		if ($listtype == 'simple')
		{
		?>
		<table class="table" style="width: 90%; margin: 0 auto;">
			<thead>
			  <tr>
				<th style="width: 25%;">Neve</th>
				<th style="width: 15%;">Típusa</th>
				<th style="width: 15%;">Státusza</th>
				<th style="width: 45%;">Helye</th>
			  </tr>
			</thead>
			<tbody>
		<?
			$content = mysqli_query($conn,"
				SELECT Id, Title, Type, Address, Status FROM Issue WHERE $searchstring ORDER BY Created DESC LIMIT $MAXISSUE OFFSET $pagenumber;");
			while($content <> null && $row = mysqli_fetch_assoc($content))
			{
				$issueid = $row["Id"];
				$issuetitle = $row["Title"];
				$issuetypetext = $issuetypesshort[$row["Type"]];
				$issueaddress = $row["Address"];
				$issuestatus = $row["Status"];
				?>
				<tr>
					<td>
						<a href="<? print("$baselink"); ?>?u=issue&i=<? print("$issueid"); ?>"><? print("$issuetitle"); ?></a>
					</td>
					<td>
						<? print("$issuetypetext"); ?>
					</td>
					<td>
						<? print("$issuestatuses[$issuestatus]"); ?>
					</td>
					<td>
						<? print("$issueaddress"); ?>
					</td>
				</tr>
				<?
			}
		?>
			</tbody>
		</table>
		<?
		}
		else
		{
		?>
		<div class="row" style="padding-left: 30px; padding-right: 30px; vertical-align: top;">
		<?
			$content = mysqli_query($conn,"
				SELECT Id, Title, Type, Address, Status, Created FROM Issue WHERE $searchstring ORDER BY Created DESC LIMIT $MAXISSUE OFFSET $pagenumber;");
			while($content <> null && $row = mysqli_fetch_assoc($content))
			{
				
				$issueid = $row["Id"];
				$issuetitle = $row["Title"];
				$issuetype = $row["Type"];
				$issuetypetext = $issuetypesshort[$row["Type"]];
				$issueaddress = $row["Address"];
				$issuestatus = $row["Status"];
				$issuecreated = strtotime($row["Created"]);

				
				$issuetypex = $issuetype;
	
				if ($issuetype > 3)
					$issuetypex--;
				
				$thumblisname = 'thumblistdiv';
				if ($row["Status"] == 2)
				{
					$thumblisname = 'thumblistdivresolved';
				}
				
				$iconurl = $baselocation."img/markers/marker_".$issuestatuscolor[$issuestatus]."_small/marker_".$issuetypex.".png";
				
				$honap = array
				("január","február","március","április",
				"május","június","július","augusztus",
				"szeptember","október","november","december");
				?>
					<div class="<? print("$thumblisname"); ?>" onclick="openissue(<? print("$issueid"); ?>);">
						<? include("pictureslistdiv.php"); ?>
						<img style="height: 40px; position: relative; top: -43px; left: 95px;" src="<? print ($iconurl); ?>" />
						<div class="thumblistcontent" style="margin-top: -40px;">
						<b style="font-size: 14px;"><? print("$issuetitle"); ?></b><br />
						<span style="font-size: 12px; font-style: italic;">
							<? 
								print(date("Y", $issuecreated).". ");
								print($honap[date("n", $issuecreated)-1]." ");
								print(date("j", $issuecreated).".");
							?>
						</span><br />
						<span style="font-size: 12px;">
						<? print("$issuetypetext"); ?> - <? print("$issuestatuses[$issuestatus]"); ?>
						</span><br />
						<span style="font-size: 12px;" title="<? print("$issueaddress"); ?>">
						<? print("$issueaddress"); ?>
						</span>
						</div>
					</div>
				<?
			
			}
		?>
		</div>
		<?
		
		}
		?>
	</div>
<?
}
?>
</div>
