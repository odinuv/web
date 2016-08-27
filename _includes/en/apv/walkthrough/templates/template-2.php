<?php

require 'latte.php';

$latte = new Latte\Engine;

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
$tplVars['pageTitle'] = 'Flintstones';
$tplVars['showBold'] = true;

$latte->render('template-2.latte', $tplVars);
