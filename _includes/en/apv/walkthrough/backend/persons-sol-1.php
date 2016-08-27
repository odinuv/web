<?php

try {
	$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit("I cannot connect to database: " . $e->getMessage());
}

$letter = 'L';

try {
	$stmt = $db->prepare(
		"SELECT first_name, last_name, nickname, AGE(birth_day) AS age, height 
		FROM person 
		WHERE first_name LIKE :pattern OR last_name LIKE :pattern
		ORDER BY height DESC, age DESC"
	);
	$stmt->bindValue(':pattern', $letter . '%');
	$stmt->execute();
	print_r($stmt->fetchAll());
} catch (PDOException $e) {
	echo "I cannot execute the query: " . $e->getMessage();
}
