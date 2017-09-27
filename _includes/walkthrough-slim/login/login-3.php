<?php
$app->post('/login', function(Request $request, Response $response, $args) {
    try {
        $input = $request->getParsedBody();
        //find user by login
        $stmt = $this->db->prepare('SELECT * FROM account WHERE login = :l');
        $stmt->bindValue(':l', $input['login']);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            //verify if hash from database matches hash of provided password
            if(password_verify($input['pass'], $user["password"])) {
                $_SESSION["user"] = $user;
                return $response->withHeader('Location', $this->router->pathFor('profile'));
            }
        }
    } catch(PDOException $e) {
        $this->logger->error($e->getMessage());
    }
    //do not reveal if account exists or not
    return $this->view->render($response, 'login.latte',[
        'message' => 'User verification failed.'
    ]);
})->setName('do-login');