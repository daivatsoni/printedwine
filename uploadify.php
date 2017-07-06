<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
require_once("./wp-load.php");
// Define a destination
$upload_dir = wp_upload_dir(); // Relative to the root
$path = $upload_dir['basedir']."/arts_tmp/";
//echo "file path : ".$path;exit;
$verifyToken = md5('unique_salt' . $_POST['timestamp']);
//echo "<pre>";print_r($path);exit;
if (!empty($_FILES) ) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath =  $path;
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
        $targetFile1 = date("d-m-Y")."-".time().'.'.$fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . date("d-m-Y")."-".time().'.'.$fileParts['extension'];
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo $targetFile1;
	} else {
		echo 'Invalid file type.';
	}
}
?>