<?php

$personName = 'Bill';

$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
$stmt = $db->prepare("SELECT * FROM person WHERE first_name = :name");
$stmt->bindValue(':name', $personName);
$stmt->execute();

print_r($stmt->fetchAll());
