<?php

$route->get('/persons', function(Request $request, Response $response, $args) {
    $queryParams = $request->getQueryParams();
    if (!empty($queryParams['search'])) {
        if (!empty($queryParams['keyword'])) {
            $keyword = $queryParams['keyword'];
        } else {
            $keyword = '';
        }
    } else {
        $keyword = '';
    }
    $tplVars['search'] = $keyword;
    $tplVars['persons'] = [
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nickname' => 'Johnny',
            'age' => '42',
        ],
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nickname' => 'Johnny',
            'age' => '42',
        ],
        [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nickname' => 'Johnny',
            'age' => '42',
        ],
    ];
    $this->view->render($response, 'persons-list-1.latte', $tplVars);
});