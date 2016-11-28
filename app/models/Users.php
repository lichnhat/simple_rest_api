<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Users extends Model {

	/* Int */
	public $id;

	/* String */
	public $uname;

	/* String */
	public $email;

	/* String */
	public $pass;

	/* String */
	public $ssid;

	public function validation() {

		$this->validate(
			new Uniqueness (
				[
					"field" => "uname",
					"message" => "Your NAME must be unique !",
				],
				[
					"field" => "email",
					"message" => "Your EMAIL must be unique !"
				]
			)
		);

	}
}