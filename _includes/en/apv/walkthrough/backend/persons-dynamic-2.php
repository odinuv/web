<?php

require 'latte.php';

$latte = new Latte\Engine;

$tplVars['pageTitle'] = 'Persons List';
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

$latte->render('persons-dynamic-2.latte', $tplVars);
