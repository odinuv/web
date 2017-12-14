<?php
require 'include/start.php';
try {
    //detect form submission
    if(!empty($_POST['save'])) {
        //update individual records
        foreach($_POST['height'] as $id => $h) {
            $stmt = $db->prepare('UPDATE person SET height = :h WHERE id_person = :id');
            //store null or actual value
            $stmt->bindValue(':h', !empty($h) ? intval($h) : null);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }
    }
    //select persons from database (young or with unknown height)
    $stmt = $db->query('
		SELECT * FROM person
		WHERE
		  birth_day >= NOW() - INTERVAL \'20\' YEAR
		  OR height IS NULL
		ORDER BY last_name, first_name
	');
    $stmt->execute();
} catch (PDOException $e) {
    exit("I cannot execute the query: " . $e->getMessage());
}
$tplVars['pageTitle'] = 'Persons List';
$tplVars['persons'] = $stmt->fetchAll();
$latte->render('templates/height-form.latte', $tplVars);
