<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    //...
});

$app->post('/add-person', function(Request $request, Response $response, $args) {
    try {
        $city = "Bucharest";    //replace with data from $_POST
        $stmt1 = $this->db->prepare("INSERT INTO location (city) VALUES (:c)");
        $stmt1->bindValue(":c", $city);
        $stmt1->execute();

        //obtain ID of new location
        $addressID = $this->db->lastInsertId("location_id_location_seq");

        $stmt2 = $this->db->prepare("INSERT INTO person
                           (..., address_id, ...)
                           VALUES
                           (..., :aid, ...)");
        $stmt2->bindValue(":aid", $addressID);
        $stmt2->execute();
    } catch(PDOException $e) {
        exit($e->getMessage());
    }
});