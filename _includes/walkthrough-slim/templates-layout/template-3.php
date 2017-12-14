<?php
$app->get('/flinstones', function (Request $request, Response $response, $args) {
    $tplVars['flintstones'] = [
        'father' => 'Fred',
        'mother' => 'Wilma',
        'child' => 'Pebbles',
    ];
    $tplVars['rubbles'] = [
        'father' => 'Barney',
        'mother' => 'Betty',
        'child' => 'Bamm-Bamm',
    ];
    $tplVars['pageTitle'] = 'The Flintstones';
    $tplVars['showBold'] = true;
    return $this->view->render($response, 'template.latte', $tplVars);
});