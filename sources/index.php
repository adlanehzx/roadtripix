<?php

use App\Core\Router;

use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\GroupController;
use App\Controllers\HomeController;
use App\Controllers\ImageController;
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

// Groups:
$router->get("/groups/{id}", GroupController::class);
$router->get("/groups/create", GroupController::class, "create");
$router->get("/groups", GroupController::class, "all");
$router->post("/groups", GroupController::class, "store");

$router->get("/groups/{groupId}/delete", GroupController::class, "deleteForm");
$router->post("/groups/{groupId}/delete", GroupController::class, "remove");

// Images:
// we show all the uploaded images of the user along with their groups (link to the group).
$router->get("/images", ImageController::class);

// to create an image
$router->get("/images/{groupId}/create", ImageController::class, "create");
$router->get("/images/{groupId}", ImageController::class, "all");
$router->post("/images/{groupId}", ImageController::class, "store");


$router->get("/images/{groupId}/delete/{imageId}", ImageController::class, "deleteForm");
$router->post("/images/{groupId}/delete/{imageId}", ImageController::class, "remove");


$router->start();
