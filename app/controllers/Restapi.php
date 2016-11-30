<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Http\Request;

class Restapi extends Controller {

	private $controllerName;

	private $modelName;

	private $response;

	private $request;

	private $ssid;

	private $id;

	public function initialize() {

		$this->controllerName = $this->dispatcher->getControllerName();

		$this->response = new Response();

		$this->request = new Request();

		$this->ssid = $this->dispatcher->getParam("ssid");

		$this->id = $this->dispatcher->getParam("id");

	}

	public function indexAction() {

	}
	/*
	 * POST register new
	 */
	public function signupAction() {

		$info_user = $this->request->getJsonRawBody();

		$uname = $pass = $email = "";

		$uname = $info_user->uname;
		$pass = $info_user->pass;
		$email = $info_user->email;

		$message = array();
		if($uname == "") {
			$message[] = "Uname";
		}
		if($pass == "") {
			$message[] = "Pass";
		}
		if($email == "") {
			$message[] = "Email";
		}

		if(empty($message)) {
			$user = new Users();
			
			$ssid = $this->session->getId();
			session_regenerate_id();
			$user->uname = $uname;
			$user->pass = $pass;
			$user->email = $email;
			$user->ssid = $ssid;

			if($user->save() === true) {
				$data = array();

				$data[] = [
					"uname" => $uname,
					"pass" => $pass,
					"email" => $email,
					"ssid" => $ssid
				];
				$this->response->setStatusCode(201, "Created");
				$this->response->setJsonContent(
					[
						"status" => "OK",
						"data" => $data,

					]
				);
			}
			else {
				$this->response->setStatusCode(409, "Conflict");
				$this->response->setJsonContent(
					[
						"status" => "Fail save",
					]
				);
			}
		}
		else {
			$this->response->setJsonContent(
				[
					"status" => "Required field !",
					"message" => $message
				]
			);
		}

		/*$this->response->setJsonContent(
			[
				"status" => "Required field !",
				"message" => $ssid,
			]
		);*/

		return $this->response;
 
	}

	/*
	 *	POST login
	 *	ADD new record
	 */
	public function loginAction() {

		$user = $this->request->getJsonRawBody();
		$uname = $user->uname;
		$pass = $user->pass;
		
		$get_user = Users::findFirst(
			[
				"uname = :uname: AND pass = :pass:",
				"bind" => [
					"uname" => $uname,
					"pass" => $pass,
				],
			]
		);

		if($get_user) {

			$data = array();

			$ip = $_SERVER["REMOTE_ADDR"];

			/* Login success then insert +1 record to recent table */
			$recent = new Recent();
			$recent->uid = $get_user->id;
			$recent->ip = $ip;
			if($recent->save() === true) {
				$this->response->setStatusCode(201, "Created");
				$data[] = [
					"uname" => $uname,
					"email" => $get_user->email,
					"ssid" => $get_user->ssid,
				];

				$this->response->setJsonContent(
					[
						"status" => "OK",
						"message" => "Insert new record to recent login and Out put info",
						"data" => $data,
					]
				);
			}

			
		}
		else {
			$this->response->setStatusCode(409, "Conflict");
			$this->response->setJsonContent(
				[
					"status" => "Errors",
					"message" => "Uname or pass not match !",
				]
			);
		}

		return $this->response;
	}

	/*
	 *	Info User By SSID
	 */
	public function infoAction() {

		$get_user = Users::findFirst(
			[
				"ssid = :ssid:",
				"bind" => [
					"ssid" => $this->ssid,
				],
			]
		);

		if($get_user) {

			$this->response->setJsonContent(
				[
					"status" => "OK",
					"data" => $get_user,
				]
			);

		}
		else {

			$this->response->setJsonContent(
				[
					"status" => "Errors",
					"message" => "User not exist !",
				]
			);

		}

		return $this->response;

	}
	/*
	 *	GET List User's recent By SSID
	 */
	public function listAction() {

		$get_user = Users::findFirst(
			[
				"ssid = :ssid:",
				"bind" => [
					"ssid" => $this->ssid,
				],
			]
		);

		if($get_user) {

			$uid = $get_user->id;
			$get_recent = Recent::find(
				[
					"uid = :uid:",
					"bind" => [
						"uid" => $uid,
					],
				]
			);

			if($get_recent) {
				$this->response->setJsonContent(
					[
						"status" => "ALL FOUND SHOW BELOW",
						"data" => $get_recent,
					]
				);
			}
			else {
				$this->response->setJsonContent(
					[
						"status" => "NO RECENT BE FOUND !",
					]
				);
			}

		}
		else {
			$this->response->setJsonContent(
				[
					"status" => "NOT EXIST",
				]
			);
		}

		return $this->response;

	}
	/*
	 *	PUT User's info By SSID
	 */
	public function updateuserAction() {

		$info_user = $this->request->getJsonRawBody();
		$pass = $info_user->pass;
		$new_pass = $info_user->new_pass;

		$get_user = Users::findFirst(
			[
				"ssid = :ssid: AND pass = :pass:",
				"bind" => [
					"ssid" => $this->ssid,
					"pass" => $pass,
				],
			]
		);

		if($get_user) {

			$get_user->pass = $new_pass;

			if($get_user->update() === true) {

				$data = array();
				$data[] = [
					"old_pass" => $pass,
					"new_pass" => $new_pass,
				];
				$this->response->setJsonContent(
					[
						"status" => "OK",
						"message" => "UPDATED",
						"data" => $data,
					]
				);

			}

		}
		else {

			$this->response->setJsonContent(
				[
					"status" => "Fail",
					"message" => "Inconrect info !",
				]
			);

		}
		return $this->response;
	}
	/*
	 *	DELETE User By SSID
	 */
	public function removeuserAction() {

	}
	/*
	 *	GET User's recent By it's id
	 */
	public function inforecentAction() {

		$get_user = Users::findFirst(
			[
				"ssid = :ssid:", 
				"bind" => [
					"ssid" => $this->ssid,
				],
			]
		);

		if($get_user) {

			$uid = $get_user->id;
			$get_recent = Recent::findFirst(
				[
					"id = :id: AND uid = :uid:",
					"bind" => [
						"id" => $this->id,
						"uid" => $uid,
					]
				]
			);

			if($get_recent) {

				$this->response->setJsonContent(
					[
						"status" => "Success !",
						"data" => $get_recent,
					]
				);

			}
			else {

				$this->response->setJsonContent(
					[
						"status" => "Errors !",
						"message" => "No record be found",
					]
				);

			}

		}
		else {

				$this->response->setJsonContent(
					[
						"status" => "Errors !",
						"message" => "No info be found",
					]
				);

		}

		return $this->response;
	}
	/*
	 *	DELETE a record By SSID
	 */
	public function removerecentAction() {

		$get_user = Users::findFirst(
			[
				"ssid = :ssid:",
				"bind" => [
					"ssid" => $this->ssid,
				],
			]
		);

		if($get_user) {

			$uid = $get_user->id;
			$get_recent = Recent::findFirst(
				[
					"id = :id: AND uid = :uid:",
					"bind" => [
						"id" => $this->id,
						"uid" => $uid,
					],
				]
			);

			if($get_recent) {

				$data = array();
				$data[] = [
					"user_id" => $uid,
					"record_id" => $get_recent->id,
				];

				if($get_recent->delete() === true) {

					$this->response->setJsonContent(
						[
							"status" => "OK",
							"message" => "DELETED",
							"data" => $data,
						]
					);

				}

			}
			else {

				$this->response->setJsonContent(
					[
						"status" => "Fail",
						"message" => "Recent wasn't be long to user !",
					]
				);

			}

		}
		else {

			$this->response->setJsonContent(
				[
					"status" => "Fail",
					"message" => "User not exits !",
				]
			);

		}

		return $this->response;

	}

}
