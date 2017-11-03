<?php

$app->get('/add-person', function(Request $request, Response $response, $args) {
    $tplVars['message'] = '';
    $this->view->render($response, 'templates/person-add.latte', $tplVars);
});