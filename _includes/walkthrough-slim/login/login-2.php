<?php
$app->post('/login', function(Request $request, Response $response, $args) {
    try {
        //retrieve login and password from request
        $login = $request->getAttribute('login');
        $pass = $request->getAttribute('pass');
        //find user by login
        $stmt = $this->db->prepare('SELECT * FROM account WHERE login = :l');
        $stmt->bindValue(':l', $login);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            //verify if hash from database matches hash of provided password
            if (password_verify($pass, $user["password"])) {
                echo "USER VERIFIED";
                exit;
            }
        }
        //do not reveal if account exists or not
        $tplVars['message'] = "User verification failed.";
    } catch (PDOException $e) {
        $tplVars['message'] = $e->getMessage();
    }
})->setName('do-login');