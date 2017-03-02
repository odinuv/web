<?php
require 'include/start.php';
if(!empty($_GET['id'])) {
    try {
        $stmt = $db->prepare("SELECT * FROM person WHERE id_person = :id");
        $stmt->bindValue(":id", $_GET['id']);
        $stmt->execute();
        $person = $stmt->fetch();
        if($person) {
            $stmt = $db->query("SELECT id_location, city, street_name, street_number
                                FROM location
                                ORDER BY city");
            $tplVars['locations'] = $stmt->fetchAll();
            $tplVars['person'] = $person;
            $latte->render('templates/person-address-3.latte', $tplVars);
        } else {
            die('No person found');
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} else {
    die('No ID');
}
