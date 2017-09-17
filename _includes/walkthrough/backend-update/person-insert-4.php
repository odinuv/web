<?php

require 'include/start.php';

$message = '';
if (!empty($_POST['save'])) {
    // user clicked on the save button
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['nickname'])) {
        $message = 'Please fill in both names and nickname';
    } elseif (empty($_POST['gender']) || ($_POST['gender'] != 'male' && $_POST['gender'] != 'female')) {
        $message = 'Gender must be either "male" or "female"';
    } else {
        // everything filled
        try {
            $stmt = $db->prepare(
                "INSERT INTO person (first_name, last_name, nickname, birth_day, gender, height) 
                VALUES (:first_name, :last_name, :nickname, :birth_day, :gender, :height)"
            );
            $stmt->bindValue(':first_name', $_POST['first_name']);
            $stmt->bindValue(':last_name', $_POST['last_name']);
            $stmt->bindValue(':nickname', $_POST['nickname']);
            $stmt->bindValue(':gender', $_POST['gender']);

            if (empty($_POST['birth_day'])) {
                $stmt->bindValue(':birth_day', null);
            } else {
                $stmt->bindValue(':birth_day', $_POST['birth_day']);
            }

            if (empty($_POST['height']) || empty(intval($_POST['height']))) {
                $stmt->bindValue(':height', null);
            } else {
                $stmt->bindValue(':height', intval($_POST['height']));
            }
            $stmt->execute();
            $message = "Person inserted";
        } catch (PDOException $e) {
            $message = "Failed to insert person (" . $e->getMessage() . ")";
        }
    }
}

$tplVars['operation'] = "Insert Person";
$tplVars['message'] = $message;
$latte->render('templates/person-insert-4.latte', $tplVars);
