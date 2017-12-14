<?php
$app->get('/person-add', function (Request $request, Response $response, $args) {
    // Existing user
    $person = [
        'id' => 123,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'nickname' => 'johnd',
        'birth_day' => '1996-01-23',
        'height' => 173,
    ];
    /*
    // New user
    $person = [
        'id' => null
        'first_name' => '',
        'last_name' => '',
        'nickname' => '',
        'birth_day' => null,
        'height' => null,
    ];
    */
    if ($person['id']) {
        $tplVars['pageTitle'] = "Edit person";
    } else {
        $tplVars['pageTitle'] = "Add new person";
    }
    $tplVars['person'] = $person;
    $this->view->addParams($tplVars);
    return $this->view->render($response, 'person-form.latte');
});