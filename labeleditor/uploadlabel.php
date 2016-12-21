<?php

	require("library/config.php");
	/*
	Server-side PHP file upload code for HTML5 File upload
	*/
	
	$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

	if ($fn) {

		// AJAX call
		file_put_contents(
			'uploads/user_1/product_1/' . $fn,
			file_get_contents('php://input')
		);

		$path = 'uploads/user_1/product_1/' . $fn;
		
		$insert_image = "INSERT INTO user_templates(template_id, userid, template_name, canvas_thumbnail, canvas_json, created_date, modified_date, label_path) VALUES ('','','','','','','','".$path."')";
		$run_Query = mysql_query($insert_image) or die("ERROR: " . $insert_image);
			
		if($run_Query)
		{
			echo "Upload image is Added Successfully.";
		}

		exit();

	}
	else {

		// form submit
		$files = $_FILES['labelselect'];

		foreach ($files['error'] as $id => $err) {
			if ($err == UPLOAD_ERR_OK) {
				$fn = $files['name'][$id];
				move_uploaded_file(
					$files['tmp_name'][$id],
					'uploads/user_1/product_1/' . $fn
				);

			$path = 'uploads/user_1/product_1/' . $fn;
			
			$insert_image = "INSERT INTO user_labels(label_id, label_name, user_id, product_id, label_path) VALUES ('','','1','1','".$path."')";
			$run_Query = mysql_query($insert_image) or die("ERROR: " . $insert_image);
				
			if($run_Query)
			{
				echo "Upload image is Added Successfully.";
			}
				echo "<p>File $fn uploaded.</p>";
			}
		}
	}
?>