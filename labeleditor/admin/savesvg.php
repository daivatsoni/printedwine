<?php

	set_time_limit(1000);

	$folderLocation = $_POST['path'];
	if(!file_exists($folderLocation)) {
	   mkdir($folderLocation, 0777, true);
	   chmod($folderLocation, 0777);
	}
	
	if (isset($_POST['svgData'])) {

		$encoded = $_POST['svgData'];
		$decoded = "";
		for ($i=0; $i < ceil(strlen($encoded)/256); $i++) {
		  $decoded = $decoded . substr($encoded,$i*256,256);
		}
		$contents = $decoded; // output
		
		file_put_contents($folderLocation."/".$_POST['filename'].".svg", $contents);
		echo $folderLocation."/".$_POST['filename'].".svg";
	}

	//echo "SVG Saved successfully";
?>