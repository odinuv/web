<?php

try {
	$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit("I cannot connect to database: " . $e->getMessage());
}

try {
	$stmt = $db->query("SELECT first_name, last_name, nickname FROM person ORDER BY first_name ASC, last_name ASC");
	print_r($stmt->fetchAll());
} catch (PDOException $e) {
	echo "I cannot execute the query: " . $e->getMessage();
}
