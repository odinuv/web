<?php

$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
$stmt = $db->query("SELECT * FROM person ORDER BY first_name");
print_r($stmt->fetchAll());
