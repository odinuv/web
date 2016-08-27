<?php

$location = [
    'name' => 'Big Ben',
    'city' => 'London',
    'country' => 'United Kingdom'
];

$db = new PDO('pgsql:host=localhost;dbname=apv', 'apv', 'apv');
$stmt = $db->prepare("INSERT INTO location (name, city, country) VALUES (:name, :city, :country)");
$stmt->bindValue(':name', $location['name']);
$stmt->bindValue(':city', $location['city']);
$stmt->bindValue(':country', $location['country']);
$stmt->execute();

$stmt->debugDumpParams();
