<?php
$app->get('/login', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'login.latte', ['message' => '']);
})->setName('login');