<?php
require 'include/start.php';
$tplVars['message'] = '';
if(!empty($_POST['login']) && !empty($_POST['pass'])) {
    try {
        //find user by login
        $stmt = $db->prepare('SELECT * FROM account WHERE login = :l');
        $stmt->bindValue(':l', $_POST['login']);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user) {
            //verify if hash from database matches hash of provided password
            if(password_verify($_POST['pass'], $user["password"])) {
                echo "USER VERIFIED";
                exit;
            }
        }
        //do not reveal if account exists or not
        $tplVars['message'] = "User verification failed.";
    } catch (PDOException $e) {
        $tplVars['message'] = $e->getMessage();
    }
}
$latte->render('templates/login.latte', $tplVars);