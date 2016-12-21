<?php
	require("library/config.php");
	
	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

	if ($fn) {
	
		$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fn);

		$test = 'uploads/'.$withoutExt.'/'.$fn;
		if (!file_exists($test)) {
		  mkdir($test, 0777, true);
		}

		/*file_put_contents(
			'uploads/'. $fn,
			file_get_contents('php://input')
		);*/
		
		file_put_contents(
			'uploads/'.$withoutExt.'/'.$fn,
			file_get_contents('php://input')
		);
		
		$insert_image = "INSERT INTO useruploads(id, imgpath, uploadname)VALUES('','".$test."','".$withoutExt."')";
		$run_Query = mysql_query($insert_image) or die("ERROR: " . $insert_image);
			
			if($run_Query)
			{
			echo "Upload image is Added Successfully.";
			}

		exit();

	}
	else {

		// form submit
		$files = $_FILES['fileselect'];

		foreach ($files['error'] as $id => $err) {
			if ($err == UPLOAD_ERR_OK) {
				$fn = $files['name'][$id];
				move_uploaded_file(
					$files['tmp_name'][$id],
					'uploads/' . $fn
				);
				echo "<p>File $fn uploaded.</p>";
			}
		}
	}
/*
$ds  = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = './uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}*/
?>