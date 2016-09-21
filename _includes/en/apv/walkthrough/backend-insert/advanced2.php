<?php
require 'include/start.php';
try {
    $city = "Bucharest";
    $stmt1 = $db->prepare("INSERT INTO location (city) VALUES (:c)");
    $stmt1->bindValue(":c", $city);
    $stmt1->execute();

    $addressID = $db->lastInsertId("location_id_location_seq");

    $stmt2 = $db->prepare("INSERT INTO person (first_name, last_name, nickname, address_id) 
    	VALUES (:first_name, :last_name, :nickname, :aid)");
    $stmt2->bindValue(":first_name", 'Janice');
    $stmt2->bindValue(":last_name", 'Doe');
    $stmt2->bindValue(":nickname", 'JD');
    $stmt2->bindValue(":aid", $addressID);
    $stmt2->execute();
} catch(PDOException $e) {
    die($e->getMessage());
}
