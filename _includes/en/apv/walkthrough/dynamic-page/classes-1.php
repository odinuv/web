<?php

// define a class
class Cow {
	public function makeMoo($count) {
		for ($i = 0; $i < $count; $i++) {
			echo "Moo!\n";
		}
	}
}

// create object from class
$betty = new Cow();

// call a method of the object
$betty->makeMoo(10);
