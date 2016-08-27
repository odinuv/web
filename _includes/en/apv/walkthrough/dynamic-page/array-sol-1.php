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

echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>$pageTitle</title>
    </head>
    <body>
    <h1>Flintstones &amp; Friends</h1>
    <ul>
    ";
foreach ($allOfThem as $familyName => $family) {
	echo "<li>$familyName
		<ul>";
	foreach ($family as $role => $name) {
		echo "<li>The $role in $familyName family is $name\n</li>";
	}
	echo "</ul></li>";
}
echo "</body></html>";
