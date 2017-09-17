<?php

class User {	
	private $firstName;
	private $lastName;
	private $email;

	public function __construct($firstName, $lastName, $email) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
	}

	public function printName() {
		echo $this->firstName . " " . $this->lastName;
	}
}

$john = new User('John', 'Doe', 'john.doe@example.com');
$jane = new User('Jane', 'Dona', 'jane.dona@example.com');

$john->printName();
$jane->printName();
