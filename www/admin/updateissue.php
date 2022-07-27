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
?>
    </head>
    <body>

<?php

function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function guidv4()
{
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

$searchterms = mysqli_real_escape_string($conn,urldecode($_GET["st"]));
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
}

if ($isissuecheck == 0)
{
?>
<script>
location.replace("<? print("$baselocation");?>admin/adminlist.php?<? print("$searchterms");?>");
</script>
<?
}

if (isset($_POST['apply']))
{
	$nissuetitle = mysqli_real_escape_string($conn,$_POST['problemtitle']);
	$nissuetype = mysqli_real_escape_string($conn,$_POST['problemtype']);
	$nissuestatus = mysqli_real_escape_string($conn,$_POST['problemstatus']);
	$nissuedescription = mysqli_real_escape_string($conn,$_POST['description']);
	$nissuesolution = mysqli_real_escape_string($conn,$_POST['solutionidea']);
	$nissueaddress = mysqli_real_escape_string($conn,$_POST['address']);
	$nissuelatitude = mysqli_real_escape_string($conn,$_POST['latitude']);
	$nissuelongitude = mysqli_real_escape_string($conn,$_POST['longitude']);
	$nissuecost = mysqli_real_escape_string($conn,$_POST['cost']);
	$nissuefixed = mysqli_real_escape_string($conn,$_POST['fixed']);
	$nissuefbevent = mysqli_real_escape_string($conn,$_POST['fbevent']);
	$nissuefbdate = mysqli_real_escape_string($conn,$_POST['fbdate']);
	$nissuesolutiontext = mysqli_real_escape_string($conn,$_POST['solutiontext']);
	
	if ($issuetitle <> $nissuetitle)
	{
		$q1 = "UPDATE Issue SET Title = '$nissuetitle' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuetype <> $nissuetype)
	{
		$q1 = "UPDATE Issue SET Type = '$nissuetype' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuestatus <> $nissuestatus)
	{
		$q1 = "UPDATE Issue SET Status = '$nissuestatus' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuedescription <> $nissuedescription)
	{
		$q1 = "UPDATE Issue SET Description = '$nissuedescription' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuesolution <> $nissuesolution)
	{
		$q1 = "UPDATE Issue SET SolutionIdee = '$nissuesolution' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issueaddress <> $nissueaddress)
	{
		$q1 = "UPDATE Issue SET Address = '$nissueaddress' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuelatitude <> $nissuelatitude)
	{
		$q1 = "UPDATE Issue SET Latitude = '$nissuelatitude' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuelongitude <> $nissuelongitude)
	{
		$q1 = "UPDATE Issue SET Longitude = '$nissuelongitude' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuecost <> $nissuecost)
	{
		$q1 = "UPDATE Issue SET Cost = '$nissuecost' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuefixed <> $nissuefixed)
	{
		$q1 = "UPDATE Issue SET Fixed = '$nissuefixed' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuefbdate <> $nissuefbdate)
	{
		$q1 = "UPDATE Issue SET FacebookEventDate = '$nissuefbdate' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	if ($issuefbevent <> $nissuefbevent)
	{
		$q1 = "UPDATE Issue SET FacebookEvent = '$nissuefbevent' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}

	if ($issuesolutiontext <> $nissuesolutiontext)
	{
		$q1 = "UPDATE Issue SET SolutionText = '$nissuesolutiontext' WHERE Id = '$issueid'";
		mysqli_query($conn, $q1);
	}
	
	$targetissue = $issueid;
	if ($targetissue > 0)
	{
		if ($_FILES['pictures']) {
			$file_ary = reArrayFiles($_FILES['pictures']);
			$i = 0;
			foreach ($file_ary as $file) {
				$originalfilename = mysqli_real_escape_string($conn,$file['name']);
				$filename = guidv4();
				
				$ext = pathinfo($originalfilename, PATHINFO_EXTENSION);
				$filename .= '.' . $ext;
				$exts = (string)$ext;
				
				if ($exts == "png" || $exts == "PNG" || $exts == "jpg" || $exts == "JPG" || $exts == "jpeg" || $exts == "JPEG")
				{
				
					$target_dir = "../imageuploads/" . $targetissue;
					
					if (!file_exists($target_dir))
						mkdir($target_dir, 0755);
					
					$target_file = "../imageuploads/" . $targetissue . "/" . $filename;
					$target_thumb = "../imageuploads/" . $targetissue . "/thumb/" . $filename;
					$target_fileX = "imageuploads/" . $targetissue . "/" . $filename;
					
					if (!file_exists($target_dir. "/thumb"))
						mkdir($target_dir. "/thumb", 0777);
					
					if (move_uploaded_file($file['tmp_name'], $target_file)) {
						chmod($target_file, 0777);
						
						// copy ($target_file, $target_thumb);
						// resize_image($target_thumb, 400, 400);
					
						$q1 = "INSERT INTO Picture 
							(Link, Title, Issue, Type, Created)
							VALUES
							('$target_fileX', '$originalfilename','$targetissue','0', now())";
						mysqli_query($conn, $q1);
					}
					else {
					}
				}
				$i++;
			}
		}
		
		if ($_FILES['picturesolution']) {
			$file_ary = reArrayFiles($_FILES['picturesolution']);
			$i = 0;
			foreach ($file_ary as $file) {
				$originalfilename = $file['name']; 
				$filename = guidv4();
				
				$ext = pathinfo($originalfilename, PATHINFO_EXTENSION);
				$filename .= '.' . $ext;
				$exts = (string)$ext;
				
				if ($exts == "png" || $exts == "PNG" || $exts == "jpg" || $exts == "JPG" || $exts == "jpeg" || $exts == "JPEG")
				{
					
					$target_dir = "../imageuploads/" . $targetissue;
					
					if (!file_exists($target_dir))
						mkdir($target_dir, 0755);
					
					$target_file = "../imageuploads/" . $targetissue . "/" . $filename;
					$target_fileX = "imageuploads/" . $targetissue . "/" . $filename;
					
					if (move_uploaded_file($file['tmp_name'], $target_file)) {
						chmod($target_file, 0755);
						$q1 = "INSERT INTO Picture 
							(Link, Title, Issue, Type, Created)
							VALUES
							('$target_fileX', '$originalfilename','$targetissue','1', now())";
						mysqli_query($conn, $q1);
					}
					else {
					}
				}
				$i++;
			}
		}
	}
	?>
	<script>
	location.replace("<? print("$baselocation");?>admin/adminlist.php?<? print("$searchterms");?>");
	</script>
	<?
}
?>
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

<div class="container" id="applicate" style="margin-top: 5px;">
	<div class="row">
		<h2 style="margin-left: 20px; margin-top: 5px;">Probléma szerkesztése</h2>


	</div>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

				<h4>Probléma</h4>
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtitle">Probléma megnevezése (*)</label>
					<div class="col-md-9">
						<input id="problemtitle" class="form-control" type="textbox" name="problemtitle" placeholder="Adj címet a problémának..." value="<? print("$issuetitle"); ?>" />
					</div>
				</div>			
			
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtype">Probléma típusa</label>
					<div class="col-md-9">
						<select id="problemtype" class="form-control" name="problemtype">
							<?
								for ($i = 0; $i < count($issuetypeslong); $i++)
								{
									if ($i == $issuetype)
										print ("<option value=\"$i\" selected>$issuetypeslong[$i]</option>");
									else
										print ("<option value=\"$i\">$issuetypeslong[$i]</option>");
								}
							?>
						</select>
					</div>
				</div>	

				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtype">Probléma státusza</label>
					<div class="col-md-9">
						<select id="problemstatus" class="form-control" name="problemstatus">
							<?
								for ($i = 0; $i < count($issuestatuses); $i++)
								{
									if ($i == $issuestatus)
										print ("<option value=\"$i\" selected>$issuestatuses[$i]</option>");
									else
										print ("<option value=\"$i\">$issuestatuses[$i]</option>");
								}
							?>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="description">Probléma története</label>
					<div class="col-md-9">
						<textarea id="solutiontext" name="solutiontext" class="form-control" placeholder="Meséld el a probléma sztoriját..." rows="2"><? print("$issuesolutiontext"); ?></textarea>
						<br />
						Figyelem: Ha a szöveg nem üres, megosztásnál ez jelenik majd meg előnézeti szövegként, leírásként.
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="description">Részletes leírás</label>
					<div class="col-md-9">
						<textarea id="description" name="description" class="form-control" placeholder="Írd le részletesen a problémát..." rows="2"><? print("$issuedescription"); ?></textarea>
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtype">Facebook esemény dátuma</label>
					<div class="col-md-9">
						<input id="fbdate" class="form-control" type="date" name="fbdate" value="<? print("$issuefbdate"); ?>" />
					</div>
				</div>		
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtitle">Facebook esemény linkje</label>
					<div class="col-md-9">
						<input id="fbevent" class="form-control" type="textbox" name="fbevent" placeholder="Adj meg egy facebook esemény linket a problémához" value="<? print("$issuefbevent"); ?>" />
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="pictures">Képek</label>
					<div class="col-md-9">
						<input id="pictures" class="form-control" type="file" name="pictures[]" multiple="multiple">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtype">Javítás dátuma</label>
					<div class="col-md-9">
						<input id="fixed" class="form-control" type="date" name="fixed" value="<? print("$issuefixed"); ?>" />
					</div>
				</div>					
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="pictures">Végeredmény képek</label>
					<div class="col-md-9">
						<input id="picturesolution" class="form-control" type="file" name="picturesolution[]" multiple="multiple">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="solutionidea">Megoldási javaslat</label>
					<div class="col-md-9">
						<textarea id="solutionidea" name="solutionidea" class="form-control" placeholder="Írd le, te hogyan oldanád meg a problémát..." rows="2"><? print("$issuesolution"); ?></textarea>
					</div>
				</div>			
				
				<div class="form-group">
					<label for="cost" class="col-md-3 control-label">Költség</label>
					<div class="col-md-9">
						<input id="cost" name="cost" class="form-control" type="textbox" placeholder="Adj meg költséget...">
					</div>
				</div>
			
				<h4>Cím (koordináták)</h4>
				<div class="form-group">
					<label for="address" class="col-md-3 control-label">Cím (*)</label>
					<div class="col-md-7">
						<input id="address" name="address" class="form-control" type="textbox" value="Budapest" placeholder="Adj meg egy címet...">
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary" onclick="codeAddress();">Keresés</button>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="latitude">Szélességi fok</label>
					<div class="col-md-9">
						<input id="latitude" name="latitude" class="form-control" type="textbox" readonly="true">
					</div>
				</div>
					
				<div class="form-group">
					<label class="col-md-3 control-label" for="longitude">Hosszúsági fok</label>
					<div class="col-md-9">
						<input id="longitude" name="longitude" class="form-control" type="textbox" readonly="true">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="map_canvas">Térkép</label>
					<div class="col-md-9">
						<div id="map_canvas"></div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<h4 style="padding-top: 10px;">Csatolt képek:</h4>
					</div>
					<?
						include("picturesfordelete.php");
					?>
				</div>
				
				<div class="form-group" id="errordiv" style="display: hidden;">
					<label for="error" class="col-md-3 control-label" style="color: red;">Hiba:</label>
					<div class="col-md-9" style="color: red;" id="errortextdiv">
						Egy vagy több kötelező mező értéke nincs kitöltve, vagy szabálytalan!
					</div>
				</div>
				
				<div class="form-group">
					<label for="submit" class="col-md-3 control-label"></label>
					<div class="col-md-9" style="text-align: right;">
						<input type="submit" id="apply" name="apply" class="btn btn-primary" value="Módosít" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>

document.getElementById('errordiv').style.display = 'none';

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validate()
{
	var iserror = 0;
	var errortext = '';
	var data = document.getElementById('problemtitle').value;
	if (data === '') { document.getElementById('problemtitle').style.borderColor = 'red'; iserror = 1; if (errortext !== '') errortext += "<br />"; errortext += "Probléma megnevezése nincs megadva!";}
	else { document.getElementById('problemtitle').style.borderColor = '#CCCCCC';}
	data = document.getElementById('address').value;
	if (data === '') { document.getElementById('address').style.borderColor = 'red'; iserror = 1; if (errortext !== '') errortext += "<br />"; errortext += "Cím (helyszín) nincs megadva!";}
	else { document.getElementById('address').style.borderColor = '#CCCCCC';}
	var files = document.getElementById("pictures").files;
	var i = 0
	for (; i < files.length; i++)
	{
		var extension = files[i].name.substr(files[i].name.length - 4);
		if (extension !== '.png' && extension !== '.PNG' && extension !== '.jpg' && extension !== '.JPG' && extension !== 'jpeg' && extension !== 'JPEG')
		{
			document.getElementById('pictures').style.borderColor = 'red'; 
			iserror = 1; 
			if (errortext !== '') 
				errortext += "<br />"; 
			errortext += "Az alábbi fájl kiterjesztése nem megfelelő: " + files[i].name + "!";
		}
	}
	
	var files = document.getElementById("picturesolution").files;
	var i = 0
	for (; i < files.length; i++)
	{
		var extension = files[i].name.substr(files[i].name.length - 4);
		if (extension !== '.png' && extension !== '.PNG' && extension !== '.jpg' && extension !== '.JPG' && extension !== 'jpeg' && extension !== 'JPEG')
		{
			document.getElementById('picturesolution').style.borderColor = 'red'; 
			iserror = 1; 
			if (errortext !== '') 
				errortext += "<br />"; 
			errortext += "Az alábbi fájl kiterjesztése nem megfelelő: " + files[i].name + "!";
		}
	}
	
	if (i > 5)
	{
		document.getElementById('pictures').style.borderColor = 'red'; 
		iserror = 1; 
		if (errortext !== '') 
			errortext += "<br />"; 
		errortext += "Legfeljebb öt kép tölthető fel egy esethez!";
	}
	
	if (iserror === 1) { 
		document.getElementById('errordiv').style.display = 'block'; 
		document.getElementById('errortextdiv').innerHTML = errortext; 
		return false;
	}
	return true;
}
	document.getElementById("latitude").value = "<? print("$issuelatitude"); ?>";
    document.getElementById("longitude").value = "<? print("$issuelongitude"); ?>";
	document.getElementById("address").value = "<? print("$issueaddress"); ?>";
	codeLatLng(1);
</script>

		<script src="<? print("$baselocation"); ?>js/bootstrap.min.js"></script>
<script>
setTimeout(function(){
    document.getElementById("latitude").value = "<? print("$issuelatitude"); ?>";
    document.getElementById("longitude").value = "<? print("$issuelongitude"); ?>";
	document.getElementById("address").value = "<? print("$issueaddress"); ?>";
	codeLatLng(1);
}, 1000)
	
</script>
		
    </body>
</html>