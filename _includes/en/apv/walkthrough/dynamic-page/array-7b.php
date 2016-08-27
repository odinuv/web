<?php

$allOfThem = [
	'flintstones' => [
		'father' => 'Fred',
		'mother' => 'Wilma',
		'child' => 'Pebbles',
	],
	'rubbles' => [
		'father' => 'Barney',
		'mother' => 'Betty',
		'child' => 'Bamm-Bamm',
	]
];

foreach ($allOfThem as $familyName => $family) {
	foreach ($family as $role => $name) {
		echo "The $role in $familyName family is $name\n";
	}
}
