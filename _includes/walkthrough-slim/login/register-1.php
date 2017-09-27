<?php
$app->get('/register', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'register.latte', [
        'message' => '',
        'form' => [
            'login' => ''
        ]
    ]);
})->setName('register');