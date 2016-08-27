<?php

require 'latte.php';
$latte = new Latte\Engine;
$tplVars['pageTitle'] = 'Persons List';
if (!empty($_GET['search'])) {
	if (!empty($_GET['keyword'])) {
		$keyword = $_GET['keyword'];
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

$latte->render('persons-list-1.latte', $tplVars);
