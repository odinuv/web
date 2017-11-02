<?php

$app->get('/test-post', function(Request $request, Response $response, $args) {
    $tplVars['postData'] = '';
    $this->view->render($response, 'post-vars.latte', $tplVars);
})->setName('showTestForm');

$app->post('/test-post', function(Request $request, Response $response, $args) {
    $tplVars['postData'] = var_export($request->getParsedBody());
    $this->view->render($response, 'post-vars.latte', $tplVars);
})->setName('processTestForm');
