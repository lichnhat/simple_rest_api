<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Request;
use Phalcon\Http\Response;

class Restapi extends Controller {
	
	/*
	 *	
	 */
	private $controllerName;

	private $modelName;

	private $response;

	private $request;

	private $id;

	private $ssid;

	public function initialize() {

		$this->response = new Response();

		$this->request = new Request();

		$this->controllerName = $this->dispatcher->getControllerName();

		$this->modelName = $this->controllerName;

		$this->id = $this->dispatcher->getParam("id");

		$this->ssid = $this->dispatcher->getParam("ssid");

	}

	/*
	 *	GET list user current in database
	 */
	public function listusersAction() {
		$modelName = $this->modelName;

		$rs = $modelName::find();

		$data = array();

		foreach($rs as $r) {
			$data[] = [
				"id" => $r->id,
				"uname" => $r->uname,
				"email" => $r->email,
				"pass" => $r->pass,
				"ssid" => $r->ssid
			];
		}

		return json_encode($data);
	}

	/*
	 * GET info active user by current id
	 */
	public function infouserAction() {
		$modelName = $this->modelName;

		$rs = $modelName::findFirst( $this->id);

		$data = array();
		if($rs === false) {
			$this->response->setJsonContent(
				[
					"status" => "NOT FOUND",
				]
			);
		}
		else {
			$this->response->setJsonContent(
				[
					"status" => "FOUND",
					"data" => [
						"id" => $rs->id,
						"uname" => $rs->uname,
						"email" => $rs->email,
						"pass" => $rs->pass,
						"ssid" => $rs->ssid
					]
				]
			);
		}

		return $this->response;
	}

	/*
	 * GET list recent of current use id 
	 */
	public function listrecentAction() {
		$modelName = $this->modelName;

		$user = Users::findFirst(
				[
					"ssid = :ssid:",
					"bind" => [
						"ssid" => $this->ssid,
					],
				]
			);
		$id = $user->id;

		$rs = $modelName::find(
				[
					"uid = :uid:",
					"bind" => [
						"uid" => $id,
					],
				]
			);
		return json_encode($rs);
	}

	/*
	 * POST save user or a recent.
	 */

	public function saveAction() {
		$modelName = $this->modelName;

		$model = new $modelName();

		$user = $this->request->getJsonRawBody();

		$model->uname = $user->uname;
		$model->email = $user->email;
		$model->pass = $user->pass;
		$model->ssid = md5($user->pass);

		if($model->save()) {
			$this->response->setStatusCode(201, "Created");
			$this->response->setJsonContent(
				[
					"status" => "OK",
					"data" => $user,
				]
			);
		}
		else {
			$this->response->setStatusCode(409, "E");

			$this->response->setJsonContent(
				[
					"status" => "Errors !",
				]
			);
		}
	}
}