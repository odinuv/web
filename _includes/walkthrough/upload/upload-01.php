<?php
require 'include/start.php';
//set target directory
$dir = './uploads';
if(isset($_FILES['user_file'])) {
	//generate a unique file name
	do {
		$fileName = sha1(rand());
	} while(file_exists($dir . '/' . $fileName));
	//call special function to handle file upload
	if(move_uploaded_file($_FILES['user_file']['tmp_name'], $dir . '/' . $fileName)) {
	    //file should be in target directory
        header('Location: upload-01.php');
    }
}
$tplVars['pageTitle'] = 'Upload file';
$latte->render('templates/upload-01.latte', $tplVars);