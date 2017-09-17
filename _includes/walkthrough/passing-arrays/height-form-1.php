<?php
require 'include/start.php';
try {
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
