<?php

$app->get('/delete', function(Request $request, Response $response, $args) {
    $this->view->render($response, 'delete.latte');
})->setName('deleteForm');

$app->post('/delete', function(Request $request, Response $response, $args) {
    //...
})->setName('delete');