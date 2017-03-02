<?php
require 'include/start.php';
try {
    //retrieve all locations
    $stmt = $db->query("SELECT id_location, city, street_name, street_number
                        FROM location
                        ORDER BY city");
    $tplVars['locations'] = $stmt->fetchAll();
    $latte->render('templates/person-address-1.latte', $tplVars);
} catch (PDOException $e) {
    die($e->getMessage());
}
