<?php
$app->get('/flintstones', function (Request $request, Response $response, $args) {
    $this->view->addParam('pageTitle', 'Flintstones');
    $this->view->addParam('showBold', true);
    $this->view->addParam(
        'flintstones',
        ['father' => 'Fred', 'mother' => 'Wilma', 'child' => 'Pebbles']
    );
    $this->view->addParam(
        'rubbles',
        ['father' => 'Barney', 'mother' => 'Betty', 'child' => 'Bamm-Bamm']
    );

    return $this->view->render($response, 'flintstones-1.latte');
});