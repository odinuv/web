<?php
//start_session() is in start.php
require 'include/start.php';
//this script checks if there is a user flag in $_SESSION
require 'include/protect.php';
if(!empty($_POST["id_person"])) {
    try {
        $stmt = $db->prepare("DELETE FROM person WHERE id_person = :idp");
        $stmt->bindValue(":idp", $_POST["id_person"]);
        $stmt->execute();
        header("Location: person-list.php");
        exit();
    } catch(PDOException $e) {
        exit($e->getMessage());
    }
}
$tplVars["pageTitle"] = "Delete a person";
$latte->render('templates/delete.latte', $tplVars);