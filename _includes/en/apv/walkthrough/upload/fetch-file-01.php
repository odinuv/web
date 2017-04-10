<?php
require 'include/start.php';
$dir = './uploads';
if(!empty($_GET['id'])) {
	try {
		$stmt = $db->prepare('SELECT * FROM file WHERE id_file = :id');
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		$fileInfo = $stmt->fetch();
		if($fileInfo) {
		    //now you can check if visitor has privilege to download requested file
            //set correct headers
			header('Content-Type: ' . $fileInfo['file_type']);
			header('Content-Disposition: inline; filename="' .
                    $fileInfo['file_name_orig'] . '"');
			//send file's contents to visitor
			readfile($dir . '/' . $fileInfo['file_name']);
		} else {
			http_response_code(404);
			exit('File not found');
		}
	} catch(PDOException $e) {
        http_response_code(500);
		exit($e->getMessage());
	}
} else {
    http_response_code(403);
	exit('Specify file id');
}