<?php

require 'include/start.php';

if(!empty($_POST["id_person"])) {
    try {
        $stmt = $db->prepare("DELETE FROM person WHERE id_person = :idp");
        $stmt->bindValue(":idp", $_POST["id_person"]);
        $stmt->execute();
    } catch(PDOException $e) {
        exit($e->getMessage());
    }
}

$tplVars["pageTitle"] = "Delete a person";
$latte->render('templates/delete.latte', $tplVars);