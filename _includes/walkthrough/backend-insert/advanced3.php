<?php
require 'include/start.php';
try {
    $db->beginTransaction();    //start transaction

    $city = "Bucharest";
    $stmt = $db->prepare("INSERT INTO location (city) VALUES (:c)");
    $stmt->bindValue(":c", $city);
    $stmt->execute();

    $addressID = $db->lastInsertId("location_id_location_seq");

    $stmt = $db->prepare("INSERT INTO person
                           (..., id_location, ...)
                           VALUES
                           (..., :aid, ...)");
    $stmt->bindValue(":aid", $addressID);
    $stmt->execute();

    // if we got to this line, both rows are inserted, we can finish the transaction
    $db->commit();
} catch(PDOException $e) {
    $db->rollBack();    //undo all changes and finish the transaction
    exit($e->getMessage());
}
