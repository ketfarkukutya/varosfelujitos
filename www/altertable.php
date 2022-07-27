<?php

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
	
	$path_parts = pathinfo($file);
	if ($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' || $path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' )
	{
		$src = imagecreatefromjpeg($file);
	}
	else
	{
		$src = imagecreatefrompng($file);
	}
	
	$dst = imagecreatetruecolor($newwidth, $newheight);
	
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	if ($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' || $path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' )
	{
		imagejpeg($dst, null, 100);
	}
	else
	{
		imagepng($dst, null, 100);
	}
	
    return $src;
}

function endsWith($currentString, $target)
{
    $length = strlen($target);
    if ($length == 0) {
        return true;
    }
 
    return (substr($currentString, -$length) === $target);
}

function loopDirectory($directoryname)
{
	echo "<br/> $directoryname\n  ";
	if ($handle = opendir($directoryname)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
			   
				if (endsWith($entry,'.jpg')==0 && endsWith($entry,'.png')==0 && endsWith($entry,'.JPG')==0 && endsWith($entry,'.PNG')==0){
					if (strpos($entry, '.') === false)
					{
						if ($entry != 'thumbnail' && $entry != 'thumb' )
							loopDirectory("$directoryname/$entry");
					}
				  //echo   "<br/> $entry: is ignored.\n  ";
				  continue;
				}
				 echo "<br/> $entry\n  ";
				 
			if (!file_exists("./$directoryname/thumbnail")) {
				mkdir("./$directoryname/thumbnail", 0777, true);
			}
			copy ("./$directoryname/".$entry, "./$directoryname/thumbnail/".$entry);
			resize_image("./$directoryname/thumbnail/".$entry, 400, 400);
			}
		}
		closedir($handle);
	}
}

loopDirectory("imageuploads", "");
?>