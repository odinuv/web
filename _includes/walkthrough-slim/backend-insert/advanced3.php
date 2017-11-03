<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    //...
});

$app->post('/add-person', function(Request $request, Response $response, $args) {
    try {
        $this->db->beginTransaction();    //start transaction

        $city = "Bucharest";
        $stmt = $this->db->prepare("INSERT INTO location (city) VALUES (:c)");
        $stmt->bindValue(":c", $city);
        $stmt->execute();

        $addressID = $this->db->lastInsertId("location_id_location_seq");

        $stmt = $this->db->prepare("INSERT INTO person
                           (..., address_id, ...)
                           VALUES
                           (..., :aid, ...)");
        $stmt->bindValue(":aid", $addressID);
        $stmt->execute();

        // if we got to this line, both rows are inserted, we can finish the transaction
        $this->db->commit();
    } catch (PDOException $e) {
        $this->db->rollBack();    //undo all changes and finish the transaction
        exit($e->getMessage());
    }
});