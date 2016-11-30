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

			$sid = session_regenerate_id();

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
					"message" => "Request User name or password",
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
	public function updateAction() {

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
				$this->response->setJsonContent(
					[
						"status" => "DONE",
						"message" => "Change password successfully",
					]
				);
			}
			else {
				$this->response->setStatusCode(409, "Conflict");
			}

		}
		else {

			$this->response->setJsonContent(
				[
					"status" => "ERRORS",
					"message" => "INCORRECT YOUR INFO"
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

			$get_recent = Recent::findFirst(
				[
					"id = :id:",
					"bind" => [
						"id" => $this->id,
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

	}

}