<?php

namespace App\Controllers;

use App\Core\Authenticator;
use App\Models\User;
use App\Requests\LoginRequest;

class LoginController extends Controller
{
  public function __construct()
  {

  }

  public function index()
  {
    return $this->render('login/index');
  }

  public function post()
  {
    $request = new LoginRequest();
    $user = User::findOneByEmail(email: $request->email);

    if (!$user) {
      echo "L'adresse email ou le mot de passe sont incorrects.";
      die();
    }

    if (!$user->isValidPassword($request->password)) {
      echo "L'adresse email ou le mot de passe sont incorrects.";
      die();
    }

    Authenticator::login($user);

    return $this->redirect('/');
  }
}
