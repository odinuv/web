<?php

require 'include/start.php';

if(!empty($_POST["id_person"])) {
    try {
        $stmt = $db->prepare("DELETE FROM person WHERE id_person = :idp");
        $stmt->bindValue(":idp", $_POST["id_person"]);
        $stmt->execute();

        //redirect to prevent accidental reload with same id_person value
        header("Location: delete.php");
    } catch(PDOException $e) {
        exit($e->getMessage());
    }
}

$tplVars["pageTitle"] = "Delete a person";
$latte->render('templates/delete.latte', $tplVars);