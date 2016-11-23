<?php
//remember to put session_start() call into start.php
require 'include/start.php';
$tplVars['message'] = '';
if(!empty($_POST['login']) && !empty($_POST['pass'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM account WHERE login = :l');
        $stmt->bindValue(':l', $_POST['login']);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user) {
            if(password_verify($_POST['pass'], $user["password"])) {
                //store user data into session and redirect
                $_SESSION["user"] = $user;
                header("Location: person-list.php");
                exit;
            }
        }
        $tplVars['message'] = "User verification failed.";
    } catch (PDOException $e) {
        $tplVars['message'] = $e->getMessage();
    }
}
$latte->render('templates/login.latte', $tplVars);