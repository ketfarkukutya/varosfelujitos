<? 
	session_start();
	include_once("../config.php");
?>
<html>
    <head>
<?
	include_once("../htmlhead.php");
	include_once("../header.php");
?>
    </head>
    <body>
	
	<div class="container" id="list" style="margin-top: 5px;">
		<div class="row">
			<h2 style="margin-left: 20px; margin-top: 5px;">Userek listája</h2>
			<table class="table" style="width: 95%; margin: 0 auto;">
				<thead>
				  <tr>
					<th style="width: 20%;">Neve</th>
					<th style="width: 20%;">Emailje</th>
					<th style="width: 20%;">LastUsed</th>
				  </tr>
				</thead>
				<tbody>
			<?
				$content = mysqli_query($conn,"
					SELECT * FROM User ORDER BY Created DESC");
				while($content <> null && $row = mysqli_fetch_assoc($content))
				{
					?>
					<tr>
						<td>
							<? print("$row[UserName]"); ?>
						</td>	
						<td>
							<? print("$row[UserEmail]"); ?>
						</td>	
						<td>
							<? //print("$row[LastUsed]"); 
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

		<script src="<? print("$baselocation"); ?>js/bootstrap.min.js"></script>
    </body>
</html>

