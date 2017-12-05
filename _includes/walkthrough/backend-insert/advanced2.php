<?php
require 'include/start.php';
try {
    $city = "Bucharest";    //replace with data from $_POST
    $stmt1 = $db->prepare("INSERT INTO location (city) VALUES (:c)");
    $stmt1->bindValue(":c", $city);
    $stmt1->execute();

    //obtain ID of new location
    $addressID = $db->lastInsertId("location_id_location_seq");

    $stmt2 = $db->prepare("INSERT INTO person
                           (..., id_location, ...)
                           VALUES
                           (..., :aid, ...)");
    $stmt2->bindValue(":aid", $addressID);
    $stmt2->execute();
} catch(PDOException $e) {
    exit($e->getMessage());
}