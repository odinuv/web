<?php
require 'include/start.php';
$tplVars['form'] = [
    'login' => '', 'pass1' => '', 'pass2' => ''
];
$tplVars['message'] = '';
if(!empty($_POST['login']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])) {
    if($_POST['pass1'] == $_POST['pass2']) {
        try {
            //prepare hash
            $pass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);
            //insert data into database
            $stmt = $db->prepare('INSERT INTO account (login, password) VALUES (:l, :p)');
            $stmt->bindValue(':l', $_POST['login']);
            $stmt->bindValue(':p', $pass);
            $stmt->execute();
            //redirect to login page
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            $tplVars['message'] = $e->getMessage();
            $tplVars['form'] = $_POST;
        }
    } else {
        $tplVars['message'] = 'Provided passwords do not match.';
        $tplVars['form'] = $_POST;
    }
}
$latte->render('templates/register.latte', $tplVars);