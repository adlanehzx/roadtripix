<?php


use App\Core\Router;

use App\Controllers\UserController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\GroupController;
use App\Controllers\GroupInvitationController;
use App\Controllers\HomeController;
use App\Controllers\ImageController;
use App\Controllers\LogoutController;
use App\Controllers\ResetPasswordController;
use App\Controllers\ImageExternalLinkController;
use App\Models\GroupInvitation;

require_once __DIR__ . "/autoload.php";
require_once __DIR__ . "/../vendor/autoload.php";

$router = new Router();


$router->get('/user_uploads/{groupId}/{imageName}', ImageController::class, 'show');


$router->get("/", HomeController::class);

$router->get("/login", LoginController::class);
$router->post("/login", LoginController::class, 'post');

$router->get("/register", RegisterController::class);
$router->post("/register", RegisterController::class, 'post');

$router->get("/reset-password", ResetPasswordController::class, "index");
$router->post("/reset-password", ResetPasswordController::class, "post");
$router->get("/reset-password/{token}/{email}", ResetPasswordController::class, "showResetForm");
$router->post("/reset-password/{token}/{email}", ResetPasswordController::class, "resetPassword");
$router->get("/reset-password/{token}/{email}", ResetPasswordController::class, "success");
$router->get("/reset-password/{token}/{email}", ResetPasswordController::class, "error");
$router->get("/reset-password/{token}/{email}", ResetPasswordController::class, "expired");



$router->get('/user', UserController::class);

$router->get("/logout", LogoutController::class);

// Groups:

// TODO: problem in orders.. order matters.

$router->get("/groups/create", GroupController::class, "create");
$router->get("/groups/{groupId}", GroupController::class);
$router->get("/groups", GroupController::class, "all");
$router->post("/groups", GroupController::class, "store");

$router->get("/groups/{groupId}/delete", GroupController::class, "deleteForm");
$router->post("/groups/{groupId}/delete", GroupController::class, "remove");

$router->get("/groups/{groupId}/users", GroupController::class, "groupUsers");

$router->post("/groups/{groupId}/users/{userId}/remove", GroupController::class, "removeUserFromGroup");

$router->post('/groups/{groupId}/users/{userId}/giveWrite', GroupController::class, "giveWriteAccess");
$router->post('/groups/{groupId}/users/{userId}/removeWrite', GroupController::class, "deleteWriteAccess");

// Images:
// we show all the uploaded images of the user along with their groups (link to the group).
$router->get("/images", ImageController::class);

// to create an image
$router->get("/images/{groupId}/create", ImageController::class, "create");
$router->get("/images/{groupId}", ImageController::class, "all");
$router->post("/images/{groupId}", ImageController::class, "store");
$router->post("/images/{groupId}/upload", ImageController::class, "store");

$router->get("/images/{groupId}/delete/{imageId}", ImageController::class, "deleteForm");
$router->post("/images/{groupId}/delete/{imageId}", ImageController::class, "remove");





// Invitations:


$router->get('/invitation/{token}', GroupInvitationController::class, "acceptInvitation");
$router->get('/invite/{groupId}', GroupInvitationController::class, "prepareInvitation");
$router->post('/invite/{groupId}', GroupInvitationController::class, "invite");



// Image External Links:

$router->get('/external-images/show/{token}', ImageExternalLinkController::class, "showImage");
$router->post('/external-images/create/{imageId}', ImageExternalLinkController::class, "createLink");



$router->start();