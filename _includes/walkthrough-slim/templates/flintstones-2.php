<?php
$app->get('/flintstones', function (Request $request, Response $response, $args) {
    $tplVars = [
        'pageTitle' => 'Flintstones',
        'showBold' => true,
            'flintstones' => [
            'father' => 'Fred',
            'mother' => 'Wilma',
            'child' => 'Pebbles',
        ]
	];
	$tplVars['rubbles'] = [
        'father' => 'Barney',
        'mother' => 'Betty',
        'child' => 'Bamm-Bamm',
    ];
	$this->view->addParams($tplVars);
	return $this->view->render($response, 'flintstones-2.latte');
});