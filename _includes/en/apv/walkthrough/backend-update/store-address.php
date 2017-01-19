<?php
require 'include/start.php';
if(!empty($_POST['id'])) {
    try {
        $lid = !empty($_POST['location_id']) ? $_POST['location_id'] : null;
        $stmt = $db->prepare("UPDATE person SET id_location = :lid WHERE id_person = :id");
        $stmt->bindValue(":id", $_POST['id']);
        $stmt->bindValue(":lid", $lid);
        $stmt->execute();
        //redirect back to address selection page
        header('Location: person-address-3.php?id=' . $_POST['id']);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} else {
    die('No ID');
}
