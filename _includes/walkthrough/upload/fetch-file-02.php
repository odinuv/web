<?php
//reset cache related headers
header_remove('Cache-Control');
header_remove('Pragma');
header_remove('Expires');
require 'include/start.php';
$dir = './uploads';
if(!empty($_GET['id'])) {
	try {
		$stmt = $db->prepare('SELECT * FROM file WHERE id_file = :id');
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		$fileInfo = $stmt->fetch();
		if($fileInfo) {
			if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
				//we know that client has some version, because the file
				//is always same, we just tell him to use cached version
				http_response_code(304);
				exit;
			} else {
				//add header with last modification time
				$lastModified = gmdate('D, d M Y H:i:s ', time()) . 'GMT';
				header('Last-Modified: ' . $lastModified);
				header('Content-Type: ' . $fileInfo['file_type']);
				header('Content-Disposition: inline; filename="' .
						$fileInfo['file_name_orig'] . '"');
				readfile($dir . '/' . $fileInfo['file_name']);
			}
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