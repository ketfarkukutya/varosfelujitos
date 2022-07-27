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

function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function guidv4()
{
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

if (isset($_POST['apply']))
{
	$issuetitle = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['problemtitle']));
	$issuetype = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['problemtype']));
	$issuedescription = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['description']));
	$issuesolution = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['solutionidea']));
	$issueaddress = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['address']));
	$issuelatitude = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['latitude']));
	$issuelongitude = htmlspecialchars(mysqli_real_escape_string($conn,$_POST['longitude']));
	
	$applicantemail = htmlspecialchars(strtolower($_POST['applicantemail']));
	
	//print("$issuetitle<br />$issuetype<br />$issuedescription<br />$issuesolution<br />$issueaddress<br />$issuelatitude<br />$issuelongitude<br />");
	
	$applicantid = 0;
	$content = mysqli_query($conn,"
		SELECT Id FROM User WHERE LOWER(UserEmail) = '$applicantemail' ORDER BY Created DESC LIMIT 1");
	while($content <> null && $row = mysqli_fetch_assoc($content))
	{
		$applicantid = $row["Id"];
	}
	
	//print("$applicantemail<br />$applicantid<br />");
	
	if ($applicantid == 0)
	{
		$q1 = "INSERT INTO User 
			(UserName, UserEmail, UserStatus, Created)
			VALUES
			('$applicantemail', '$applicantemail',0,now())";
		mysqli_query($conn, $q1);
		
		$content = mysqli_query($conn,"
			SELECT Id FROM User WHERE LOWER(UserEmail) = '$applicantemail' ORDER BY Created DESC LIMIT 1");
		while($content <> null && $row = mysqli_fetch_assoc($content))
		{
			$applicantid = $row["Id"];
		}
	}
	
	$q1 = "INSERT INTO Issue
			(Title, Type, Description, SolutionIdee, Address, Latitude, Longitude, Status, AssignedUser, ApplicantUser, Created, LastUpdated)
			VALUES
			(
				'$issuetitle', 
				'$issuetype',
				'$issuedescription',
				'$issuesolution',
				'$issueaddress',
				'$issuelatitude',
				'$issuelongitude',
				'0',
				'0',
				'$applicantid',
				now(),
				now())";
	mysqli_query($conn, $q1);
	
	$targetissue = 0;
	$content = mysqli_query($conn,"
		SELECT Id FROM Issue WHERE Latitude = '$issuelatitude' AND Longitude = '$issuelongitude' AND ApplicantUser = '$applicantid' ORDER BY Created DESC LIMIT 1");
	while($content <> null && $row = mysqli_fetch_assoc($content))
	{
		$targetissue = $row["Id"];
	}
	
	if ($targetissue > 0)
	{
		if ($_FILES['pictures']) {
			$file_ary = reArrayFiles($_FILES['pictures']);
			$i = 0;
			foreach ($file_ary as $file) {
				$originalfilename = $file['name'];
				$filename = guidv4();
				$ext = pathinfo($originalfilename, PATHINFO_EXTENSION);
				$filename .= '.' . $ext;
				$exts = (string)$ext;
				
				if ($exts == "png" || $exts == "PNG" || $exts == "jpg" || $exts == "JPG" || $exts == "jpeg" || $exts == "JPEG")
				{
					$target_dir = "imageuploads/" . $targetissue;
					
					if (!file_exists($target_dir))
						mkdir($target_dir, 0777);
					else
						chmod($target_dir, 0777);
					
					if (!file_exists($target_dir. "/thumb"))
						mkdir($target_dir. "/thumb", 0777);
					else
						chmod($target_dir. "/thumb", 0777);
		
					$target_file = $target_dir . "/" . $filename;
					$target_thumb = $target_dir . "/thumb/" . $filename;
					
					if (move_uploaded_file($file['tmp_name'], $target_file)) {
						chmod($target_file, 0777);
						
						//copy ($target_file, $target_thumb);
						//resize_image($target_thumb, 400, 400);
						
						$q1 = "INSERT INTO Picture 
							(Link, Title, Issue, Created)
							VALUES
							('$target_file', '$originalfilename','$targetissue',now())";
						mysqli_query($conn, $q1);
					}
					else {
					}
				}
				$i++;
			}
		}
	}
	print("<script> document.location.href='$baselocation?u=success&i=$targetissue';</script>");
}



?>
<div class="container" id="applicate" style="margin-top: 5px; display: none;">
<?
if ($pagetype == 2)
{
?>
	<div class="row">
		<h2 style="margin-left: 20px; margin-top: 5px;">Probléma bejelentése</h2>


	</div>
	<div class="row">
		<div class="col-md-12">
			<form class="form-horizontal" role="form" method="post"  enctype="multipart/form-data">

				<h4>Probléma</h4>
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtitle">Probléma megnevezése (*)</label>
					<div class="col-md-9">
						<input id="problemtitle" class="form-control" type="textbox" name="problemtitle" placeholder="Adj címet a problémának...">
					</div>
				</div>			
			
				<div class="form-group">
					<label class="col-md-3 control-label" for="problemtype">Probléma típusa</label>
					<div class="col-md-9">
						<select id="problemtype" class="form-control" name="problemtype">
							<?
								for ($i = 0; $i < count($issuetypeslong); $i++)
								{
									print ("<option value=\"$i\">$issuetypeslong[$i]</option>");
								}
							?>
						</select>
					</div>
				</div>		
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="description">Részletes leírás</label>
					<div class="col-md-9">
						<textarea id="description" name="description" class="form-control" placeholder="Írd le részletesen a problémát..." rows="2"></textarea>
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="pictures">Képek (*)</label>
					<div class="col-md-9">
						<input id="pictures" class="form-control" type="file" name="pictures[]" multiple="multiple">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label" for="solutionidea">Megoldási javaslat</label>
					<div class="col-md-9">
						<textarea id="solutionidea" name="solutionidea" class="form-control" placeholder="Írd le, te hogyan oldanád meg a problémát..." rows="2"></textarea>
					</div>
				</div>			
			
				<h4>Cím (koordináták)</h4>
				<!-- <div class="form-group"> -->
					<!-- <label class="col-md-3 control-label"></label> -->
					<!-- <div class="col-md-9"> -->
						<!-- <button type="button" class="btn btn-primary" onclick="getActualPosition();">Jelenlegi helyzet keresése</button> -->
					<!-- </div> -->
				<!-- </div> -->
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
				
				<h4>Bejelentő</h4>
				<div class="form-group">
					<label class="col-md-3 control-label" for="applicantemail">E-mail cím (*)</label>
					<div class="col-md-9">
						<input id="applicantemail" name="applicantemail" class="form-control" type="textbox" placeholder="Add meg a saját e-mail címedet...">
					</div>
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
						<input type="submit" id="apply" name="apply" class="btn btn-success" value="Bejelentés" onclick="return validate();" />
					</div>
				</div>
			</form>
		</div>
	</div>
<?
}
?>
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
	data = document.getElementById('applicantemail').value;
	if (data === '') { document.getElementById('applicantemail').style.borderColor = 'red'; iserror = 1; if (errortext !== '') errortext += "<br />"; errortext += "E-mail cím nincs megadva!";}
	else { document.getElementById('applicantemail').style.borderColor = '#CCCCCC';
		if (!validateEmail(data)) { document.getElementById('applicantemail').style.borderColor = 'red'; iserror = 1; if (errortext !== '') errortext += "<br />"; errortext += "E-mail cím formátuma nem megfeleő!";}
		else { document.getElementById('applicantemail').style.borderColor = '#CCCCCC';}
	}
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
	
	if (i > 5)
	{
		document.getElementById('pictures').style.borderColor = 'red'; 
		iserror = 1; 
		if (errortext !== '') 
			errortext += "<br />"; 
		errortext += "Legfeljebb öt kép tölthető fel egy esethez!";
	}
	
	if (i < 1)
	{
		document.getElementById('pictures').style.borderColor = 'red'; 
		iserror = 1; 
		if (errortext !== '') 
			errortext += "<br />"; 
		errortext += "Legalább egy képet fel kell tölteni az esethez!";
	}
	
	if (iserror === 1) { 
		document.getElementById('errordiv').style.display = 'block'; 
		document.getElementById('errortextdiv').innerHTML = errortext; 
		return false;
	}
	return true;
}
</script>