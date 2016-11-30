<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\Uniqueness;

class Users extends Model {

	public $id;

	public $uname;

	public $email;

	public $pass;

	public $ssid;

	public function validation() {

		$this->validate(
			new Uniqueness(
				[
					"field" => "uname",
					"message" => "Đăng nhập đã tồn tại !"
				],
				[
					"field" => "email",
					"message" => "Email đã tồn tại !",
				]
			)
		);

	}

}