<?php

function makeMoo($count) {
	$hello = '';
	for ($i = 0; $i < $count; $i++) {
		$hello .= "Moo!\n";
	}
	return $hello;
}

echo makeMoo(10);
