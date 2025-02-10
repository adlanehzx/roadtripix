<?php

use App\Core\Router;

use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\GroupController;
use App\Controllers\HomeController;
use App\Controllers\LogoutController;

require_once __DIR__ . "/autoload.php";

$router = new Router();

$router->get("/", HomeController::class);

$router->get("/login", LoginController::class);
$router->post("/login", LoginController::class, 'post');

$router->get("/register", RegisterController::class);
$router->post("/register", RegisterController::class, 'post');

$router->get('/user', UserController::class);


$router->get("/logout", LogoutController::class);


$router->get("/groups", GroupController::class);
$router->get("/groups/create", GroupController::class, "create");
$router->post("/groups", GroupController::class, "store");

$router->start();
