<?php
require 'include/start.php';
$dir = './uploads';
if(isset($_FILES['user_file']) && !empty($_POST['id_person'])) {
	do {
		$fileName = sha1(rand());
	} while(file_exists($dir . '/' . $fileName));
	if (move_uploaded_file($_FILES['user_file']['tmp_name'], $dir . '/' . $fileName)) {
		try {
			//store information about file into database and associate with person
			$stmt = $db->prepare('INSERT INTO file
			                      (id_person, file_name, file_name_orig, file_type)
								  VALUES
								  (:idp, :fn, :fno, :ft)');
			$stmt->bindValue(':idp', $_POST['id_person']);
			$stmt->bindValue(':fn', $fileName);
			$stmt->bindValue(':fno', $_FILES['user_file']['name']);
			$stmt->bindValue(':ft', $_FILES['user_file']['type']);
			$stmt->execute();
			header('Location: upload-02.php');
		} catch(PDOException $e) {
			exit($e->getMessage());
		}
	} else {
		exit('File upload failed');
	}
}
//fetch persons from database
try {
	$stmt = $db->query('SELECT * FROM person ORDER BY last_name');
	$tplVars['persons'] = $stmt->fetchAll();
} catch(PDOException $e) {
	exit($e->getMessage());
}
$tplVars['pageTitle'] = 'Upload file';
$latte->render('templates/upload-02.latte', $tplVars);