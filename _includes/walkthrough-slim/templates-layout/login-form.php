<?php
$app->get('/login', function(Request $request, Response $response, $args) {
    $this->view->render($response, 'login-form.latte');
});