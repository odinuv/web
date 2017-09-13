<?php

$allOfThem = [
	'Flintstones' => [
		'father' => 'Fred',
		'mother' => 'Wilma',
		'child' => 'Pebbles',
	],
	'Rubbles' => [
		'father' => 'Barney',
		'mother' => 'Betty',
		'child' => 'Bamm-Bamm',
	]
];

foreach ($allOfThem as $familyName => $family) {
	foreach ($family as $role => $name) {
		echo "The $role in the $familyName family is $name\n";
	}
}
