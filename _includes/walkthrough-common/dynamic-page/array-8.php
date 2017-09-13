<?php

$flintstones['father'] = 'Fred';
$flintstones['mother'] = 'Wilma';
$flintstones['child'] = 'Pebbles';

unset($flintstones['child']);

print_r($flintstones);