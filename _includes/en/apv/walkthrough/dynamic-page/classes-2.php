<?php

// define a class
class Cow {
	private $name;

	public function __construct($name) {
		$this->name = $name;
	}

	public function makeMoo($count) {
		echo $this->name . ' says: ';
		for ($i = 0; $i < $count; $i++) {
			echo "Moo!\n";
		}
	}
}

// create object from class
$betty = new Cow('Betty');

// call a method of the object
$betty->makeMoo(10);
