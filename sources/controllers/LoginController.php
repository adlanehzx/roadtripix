<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../requests/LoginRequest.php";

class LoginController
{
  public static function index(): void
  {
    require_once __DIR__ . "/../views/login/index.php";
  }

  public static function post(): void
  {
    $request = new LoginRequest();
    $user = User::findOneByEmail($request->email);

    if (!$user) {
      echo "L'adresse email ou le mot de passe sont incorrects.";
      die();
    }

    if (!$user->isValidPassword($request->password)) {
      echo "L'adresse email ou le mot de passe sont incorrects.";
      die();
    }

    echo "Envoyer une session";
  }
}
