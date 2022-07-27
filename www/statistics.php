<div class="container" id="statistics" style="margin-top: 5px; display: none;">
<?
if ($pagetype == 3)
{
	
?>
	<script src="<? print("$baselocation"); ?>js/chart.js"></script>
	<div class="row">
		<h2 style="margin-left: 20px; margin-top: 5px;">Statisztikák</h2>
	</div>	
	
	<div class="row">
		<div class="col-md-6" style="text-align: center;">
			<canvas id="chartPercentage" width="400" height="300"></canvas>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<table style="width: 99%; margin: 0 auto;">
				<tr style="border-bottom-width: 1px; border-bottom-style: solid;">
					<th style="width: 50%;">Típus</th>
					<th style="width: 50%; text-align: right;">Megoldási százalék</th>
				</tr>
			<?
				$noe = 0;
				$stringforcolumns = "";
				$stringforcolor = "";
				$stringfordata = "";
				$content = mysqli_query($conn,"
					SELECT CONVERT(Type,UNSIGNED INTEGER) as TypeInt, SUM(IF(Status IN (0,1),0,1)) as Percentage, COUNT(1) as Num
					FROM Issue
					GROUP BY TypeInt
					ORDER BY TypeInt ASC
					");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{	
					$noe++;
					$issuetypetext = $issuetypesshort[$row["TypeInt"]];
					$percentage = $row["Percentage"]*100;
					$num = $row["Num"];
					$percentage = round($percentage/$num);
					
					if ($noe > 1)
					{
						$stringforcolumns.= ", ";
						$stringforcolor.= ", ";
						$stringfordata.= ", ";
					}
					
					$stringforcolumns.="\"$issuetypetext\"";
					$stringforcolor.="\"#904F3E\"";
					$stringfordata.="$percentage";
					
					?>
					<tr>
						<td>
							<? print("$issuetypetext"); ?>
						</td>
						<td style=" text-align: right;">
							<? print("$percentage"."% ($num)"); ?>
						</td>
					</tr>
					<?
				}
			?>
			</table>
			<script>
				new Chart(document.getElementById("chartPercentage"), {
					type: 'bar',
					data: {
					  labels: [<? print("$stringforcolumns"); ?>],
					  datasets: [
						{
						  label: "Megoldási százalék",
						  backgroundColor: [<? print("$stringforcolor"); ?>],
						  data: [<? print("$stringfordata"); ?>]
						}
					  ]
					},
					options: {
					  legend: { display: false },
					  title: {
						display: true,
						text: 'Megoldási százalékok típusok szerint'
					  }
					}
				});
			</script>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6" style="text-align: center;">
			<table style="width: 99%; margin: 0 auto;">
				<tr style="border-bottom-width: 1px; border-bottom-style: solid;">
					<th style="width: 50%;">Típus</th>
					<th style="width: 50%; text-align: right;">Megoldatlan bejelentések</th>
				</tr>
			<?
				$noe = 0;
				$stringforcolumns = "";
				$stringforcolor = "";
				$stringfordata = "";
				$content = mysqli_query($conn,"
					SELECT CONVERT(Type,UNSIGNED INTEGER) as TypeInt, COUNT(1) as Num
					FROM Issue
					WHERE Status IN (0,1)
					GROUP BY TypeInt
					ORDER BY TypeInt ASC
					");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{	
					$noe++;
					$issuetypetext = $issuetypesshort[$row["TypeInt"]];
					$num = $row["Num"];
					
					if ($noe > 1)
					{
						$stringforcolumns.= ", ";
						$stringforcolor.= ", ";
						$stringfordata.= ", ";
					}
					
					$stringforcolumns.="\"$issuetypetext\"";
					$stringforcolor.="\"#904F3E\"";
					$stringfordata.="$num";
					
					?>
					<tr>
						<td>
							<? print("$issuetypetext"); ?>
						</td>
						<td style=" text-align: right;">
							<? print("$num"); ?>
						</td>
					</tr>
					<?
				}
			?>
			</table>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<canvas id="chartUnresolved" width="400" height="300"></canvas>
		</div>
			<script>
				new Chart(document.getElementById("chartUnresolved"), {
					type: 'bar',
					data: {
					  labels: [<? print("$stringforcolumns"); ?>],
					  datasets: [
						{
						  label: "Megoldatlan bejelentések",
						  backgroundColor: [<? print("$stringforcolor"); ?>],
						  data: [<? print("$stringfordata"); ?>]
						}
					  ]
					},
					options: {
					  legend: { display: false },
					  title: {
						display: true,
						text: 'Megoldatlan bejelentések típusok szerint'
					  }
					}
				});
			</script>
	</div>
	
	<div class="row">
		<div class="col-md-6" style="text-align: center;">
			<canvas id="chartResolved" width="400" height="300"></canvas>
		</div>
		<div class="col-md-6" style="text-align: center;">
			<table style="width: 99%; margin: 0 auto;">
				<tr style="border-bottom-width: 1px; border-bottom-style: solid;">
					<th style="width: 50%;">Típus</th>
					<th style="width: 50%; text-align: right;">Megoldott bejelentések</th>
				</tr>
			<?
				$noe = 0;
				$stringforcolumns = "";
				$stringforcolor = "";
				$stringfordata = "";
				$content = mysqli_query($conn,"
					SELECT CONVERT(Type,UNSIGNED INTEGER) as TypeInt, COUNT(1) as Num
					FROM Issue
					WHERE Status NOT IN (0,1)
					GROUP BY TypeInt
					ORDER BY TypeInt ASC
					");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{	
					$noe++;
					$issuetypetext = $issuetypesshort[$row["TypeInt"]];
					$num = $row["Num"];
					
					if ($noe > 1)
					{
						$stringforcolumns.= ", ";
						$stringforcolor.= ", ";
						$stringfordata.= ", ";
					}
					
					$stringforcolumns.="\"$issuetypetext\"";
					$stringforcolor.="\"#904F3E\"";
					$stringfordata.="$num";
					
					?>
					<tr>
						<td>
							<? print("$issuetypetext"); ?>
						</td>
						<td style=" text-align: right;">
							<? print("$num"); ?>
						</td>
					</tr>
					<?
				}
			?>
			</table>
		</div>
			<script>
				new Chart(document.getElementById("chartResolved"), {
					type: 'bar',
					data: {
					  labels: [<? print("$stringforcolumns"); ?>],
					  datasets: [
						{
						  label: "Megoldott bejelentések",
						  backgroundColor: [<? print("$stringforcolor"); ?>],
						  data: [<? print("$stringfordata"); ?>]
						}
					  ]
					},
					options: {
					  legend: { display: false },
					  title: {
						display: true,
						text: 'Megoldott bejelentések típusok szerint'
					  }
					}
				});
			</script>
	</div>
	
	<div class="row">
		<div class="col-md-12" style="text-align: center;">
			<h4>Leggyorsabban megoldott bejelentések</h4>
			<table class="table" style="width: 95%; margin: 0 auto;">
				<thead>
				  <tr>
					<th style="width: 30%;">Neve</th>
					<th style="width: 30%;">Típus</th>
					<th style="width: 40%; text-align: right;">Megoldási idő</th>
				  </tr>
				</thead>
				<tbody>
			<?
				$content = mysqli_query($conn,"
					SELECT Title, Id, Type, TIMEDIFF(Fixed,Created) as Difference
					FROM Issue
					WHERE Fixed IS NOT NULL
					ORDER BY DATEDIFF(Fixed,Created) ASC
					LIMIT 0,5
					");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{
					$issueid = $row["Id"];
					$issuetitle = $row["Title"];
					$issuetypetext = $issuetypesshort[$row["Type"]];
					$difference = explode(":",$row["Difference"]);
					$days = round($difference[0]/24);
					$difference[0]-=(24*$days)
					
					?>
					<tr>
						<td>
							<a href="<? print("$baselocation"); ?>?u=issue&i=<? print("$issueid"); ?>"><? print("$issuetitle"); ?></a>
						</td>
						<td>
							<? print("$issuetypetext"); ?>
						</td>
						<td style=" text-align: right;">
							<? 
								if ($days > 0) { print("$days nap $difference[0] óra $difference[1] perc "); }
								else { print("$difference[0] óra $difference[1] perc "); }
							?>
						</td>
					</tr>
					<?
				}
			?>
				</tbody>
			</table>
		</div>
	</div>
	
<?
}
?>
</div>
