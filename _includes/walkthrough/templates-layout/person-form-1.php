<?php

require 'latte.php';

$latte = new Latte\Engine();
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

$latte->render('person-form-1.latte', $tplVars);
    