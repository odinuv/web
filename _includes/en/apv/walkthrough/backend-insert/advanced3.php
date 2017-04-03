<?php
require 'include/start.php';
try {
    $db->beginTransaction();    //start transaction

    $city = "Bucharest";
    $stmt1 = $db->prepare("INSERT INTO location (city) VALUES (:c)");
    $stmt1->bindValue(":c", $city);
    $stmt1->execute();

    $addressID = $db->lastInsertId("location_id_location_seq");

    $stmt2 = $db->prepare("INSERT INTO person
                           (..., address_id, ...)
                           VALUES
                           (..., :aid, ...)");
    $stmt2->bindValue(":aid", $addressID);
    $stmt2->execute();

    // if we got to this line, both rows are inserted, we can finish the transaction
    $db->commit();
} catch(PDOException $e) {
    $db->rollBack();    //undo all changes and finish the transaction
    exit($e->getMessage());
}
