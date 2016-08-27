<?php

require 'latte.php';
$latte = new Latte\Engine;
$tplVars['pageTitle'] = 'Persons List';

try {
	$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit("I cannot connect to database: " . $e->getMessage());
}

try {
	$stmt = $db->query(
		"SELECT first_name, last_name, nickname, date_part('years', AGE(birth_day)) AS age 
		FROM person
		ORDER BY last_name ASC, first_name ASC"
	);
	$tplVars['persons'] = $stmt->fetchAll();
} catch (PDOException $e) {
	exit("I cannot execute the query: " . $e->getMessage());
}

$latte->render('persons-list.latte', $tplVars);
