<?php

$flintstones['father'] = 'Fred';
$flintstones['mother'] = 'Wilma';
$flintstones['child'] = 'Pebbles';

$rubbles['father'] = 'Barney';
$rubbles['mother'] = 'Betty';
$rubbles['child'] = 'Bamm-Bamm';

$allOfThem['flintstones'] = $flintstones;
$allOfThem['rubbles'] = $rubbles;

echo $flintstones['father'];
echo $rubbles['mother'];
echo $allOfThem['flintstones']['child'];

