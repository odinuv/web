<?php
$app->get('/render-form', function(Request $request, Response $response, $args) {
    return $this->view->render($response, 'post-demo.latte');
});

$app->post('/show-form-data', function(Request $request, Response $response, $args) {
    echo "Press F5 now<br><pre>";
    print_r($request->getParsedBody());
    echo "</pre>";
})->setName('showData');