<?php

namespace App\Controllers;

use App\Core\Authenticator;
use App\Models\User;
use App\Requests\LoginRequest;
use App\Services\Validator\UserValidator;

class LoginController extends Controller
{
  private ?UserValidator $userValidator = null;

  public function __construct()
  {
    $this->userValidator = new UserValidator();
  }

  public function index()
  {
    return $this->render('login/index');
  }

  public function post()
  {
    $request = new LoginRequest();
    $errors = $this->userValidator->validateLogin($request);

    if (!empty($errors)) {
      return $this->render('login/index', ['errors' => $errors]);
    }

    $user = User::findOneByEmail(email: $request->email);

    if (!$user || !$user->isValidPassword($request->password)) {
      $errors['email'][] = "L'adresse email ou le mot de passe sont incorrects.";
      return $this->render('login/index', ['errors' => $errors]);
    }

    Authenticator::login($user);

    return $this->redirect('/');
  }
}
