<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    $this->view->render($response, 'person-add.latte');
});