<?php
	// outputs the username that owns the running php/httpd process

	// (on a system with the "whoami" executable in the path)
	//echo exec('type -a convert');

	//echo exec("bash cylinderize.sh -m vertical -r 150 -l 310 -w 100 -p 6 -d both -e 1.4 -a 0 -v background -b none -f none wallpaper.png mug_base2.png out.png");

	//echo exec("bash cylinderize.sh -m vertical -r 150 -l 310 -w 100 -p 6 -d both -e 1.4 -a 0 -v background -b none -f none label3.png mug_base2.png out.png");

	//echo exec("bash cylinderize.sh -m vertical -r 190 -l 500 -w 100 -p 6 -d both -e 1.4 -o -20+150 -a 0 -v background -b none -f none wallpaper.png bottle2.png out3.png");

	$labelfile = $_POST['labelfile'];
	$templateid = $_POST['templateid'];
	$outfile = "labeloutput/output".$templateid.".png";
	$cmd = "bash cylinderize.sh -m vertical -r 187 -l 500 -w 40 -p 6 -d both -e 1.4 -o -17+150 -a 0 -v background -b none -f none " . $labelfile . " images/bottle1.png ".$outfile;
	exec($cmd);
	echo $outfile."?rand=".rand();
	//makeThumbnails("labeloutput", "output.png");

	/*function makeThumbnails($updir, $img)
	{
	    $thumbnail_width = 65;
	    $thumbnail_height = 250;
	    $thumb_beforeword = "thumb";
	    $arr_image_details = getimagesize("$updir" .  '/' . "$img"); // pass id to thumb name
	    $original_width = $arr_image_details[0];
	    $original_height = $arr_image_details[1];
	    if ($original_width > $original_height) {
	        $new_width = $thumbnail_width;
	        $new_height = intval($original_height * $new_width / $original_width);
	    } else {
	        $new_height = $thumbnail_height;
	        $new_width = intval($original_width * $new_height / $original_height);
	    }
	    $dest_x = intval(($thumbnail_width - $new_width) / 2);
	    $dest_y = intval(($thumbnail_height - $new_height) / 2);
	    if ($arr_image_details[2] == IMAGETYPE_GIF) {
	        $imgt = "ImageGIF";
	        $imgcreatefrom = "ImageCreateFromGIF";
	    }
	    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
	        $imgt = "ImageJPEG";
	        $imgcreatefrom = "ImageCreateFromJPEG";
	    }
	    if ($arr_image_details[2] == IMAGETYPE_PNG) {
	        $imgt = "ImagePNG";
	        $imgcreatefrom = "ImageCreateFromPNG";
	    }
	    if ($imgt) {
	        $old_image = $imgcreatefrom("$updir" . '/' . "$img");
	        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	        $imgt($new_image, "$updir" . '/' . "$thumb_beforeword" . "$img");
	    }
	}*/
?>