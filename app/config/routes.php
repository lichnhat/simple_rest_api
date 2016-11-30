<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->removeExtraSlashes(true);

/*
 * Index
 */
$router->add("/", [
	"controller" => "index",
	"action" => "index",
]);
/*
 *	POST register new
 */
$router->addPost("/register", [
	"controller" => "users",
	"action" => "signup",
]);
/*
 * POST Login users
 * add new recent
 */
$router->addPost("/login", [
	"controller" => "users",
	"action" => "login",
]);

/*
 * GET info current user
 */
$router->addGet("/users/([0-9A-Za-z]+)", [
	"controller" => "users",
	"action" => "info",
	"ssid" => 1,
]);
/*
 * GET recent current
 */
$router->addGet("/recent/([0-9A-Za-z]+)", [
	"controller" => "recent",
	"action" => "list",
	"ssid" => 1,
]);
/*
 * PUT user info
 */
$router->addPut("/users/([0-9A-Za-z]+)", [
	"controller" => "users",
	"action" => "updateuser",
	"ssid" => 1,
]);
/*
 * DELETE user info
 */
$router->addDelete("/users/([0-9A-Za-z]+)", [
	"controller" => "users",
	"action" => "removeuser",
	"ssid" => 1,
]);
/*
 * GET user's recent by recent's id
 */
$router->addGet("/recent/([0-9A-Za-z]+)/([0-9]+)", [
	"controller" => "recent",
	"action" => "inforecent",
	"ssid" => 1,
	"id" => 2,
]);
/*
 * DELETE user's recent by recent's id
 */
$router->addDelete("/recent/([0-9A-Za-z]+)/([0-9]+)", [
	"controller" => "users",
	"action" => "removerecent",
	"ssid" => 1,
	"id" => 2,
]);
return $router;
