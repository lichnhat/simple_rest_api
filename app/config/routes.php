<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->removeExtraSlashes(true);

/*
 *	Add URI
 */
$router->add("/", [
	"controller" => "index",
	"action" => "index"
]);

/*
 * POST add user
 * POST add recent
 */
$router->addPost("/users",[
	"controller" => "users",
	"action" => "save",
]);

/*
 * GET users
 */
$router->addGet("/users",[
	"controller" => "users",
	"action" => "listusers",
]);

/* GET info User by ID */
/* GET recent Login by ID */
/* GET list */
$router->addGet("/users/([0-9]+)", [
	"controller" => "users",
	"action" => "infouser",
	"id" => 1,
]);

/*
 * GET all recent 
 */
$router->addGet("/recent/([a-z0-9A-Z\_\-]+)", [
	"controller" => "recent",
	"action" => "listrecent",
	"ssid" => 1,
]);
