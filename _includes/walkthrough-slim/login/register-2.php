<?php
$app->post('/register', function(Request $request, Response $response, $args) {
    $tplVars = [
        'message' => '',
        'form' => [
            'login' => ''
        ]
    ];
    $input = $request->getParsedBody();
    if(!empty($input['login'] && !empty($input['pass1']) && !empty($input['pass2']))) {
        if($input['pass1'] == $input['pass2']) {
            try {
                //prepare hash
                $pass = password_hash($input['pass1'], PASSWORD_DEFAULT);
                //insert data into database
                $stmt = $this->db->prepare('INSERT INTO account (login, password) VALUES (:l, :p)');
                $stmt->bindValue(':l', $input['login']);
                $stmt->bindValue(':p', $pass);
                $stmt->execute();
                //redirect to login page
                return $response->withHeader('Location', $this->router->pathFor('login'));
                exit;
            } catch (PDOException $e) {
                $this->logger->error($e->getMessage());
                $tplVars['message'] = 'Database error.';
                $tplVars['form'] = $input;
            }
        } else {
            $tplVars['message'] = 'Provided passwords do not match.';
            $tplVars['form'] = $input;
        }
    }
    return $this->view->render($response, 'register.latte', $tplVars);
})->setName('do-register');